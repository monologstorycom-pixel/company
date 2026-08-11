<?php

namespace App\Services;

use App\Repositories\ChatbotRuleRepository;
use App\Repositories\ChatHistoryRepository;
use App\Models\ChatHistory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Article;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatbotService
{
    /**
     * Rate limiting: max requests per minute per IP.
     */
    const RATE_LIMIT_PER_MINUTE = 30;

    /**
     * Rate limiting: max requests per hour per IP.
     */
    const RATE_LIMIT_PER_HOUR = 200;

    /**
     * Cache TTL for message responses (5 minutes).
     */
    const MESSAGE_CACHE_TTL = 300;

    /**
     * Intent constants for better code readability.
     */
    const INTENT_GREETING = 'greeting';
    const INTENT_GOODBYE = 'goodbye';
    const INTENT_THANKS = 'thanks';
    const INTENT_PRODUCT_LIST = 'product_list';
    const INTENT_PRODUCT_SEARCH = 'product_search';
    const INTENT_PRODUCT_CATEGORY = 'product_category';
    const INTENT_PRODUCT_FEATURED = 'product_featured';
    const INTENT_PRODUCT_PRICE = 'product_price';
    const INTENT_ORDER = 'order';
    const INTENT_CONTACT = 'contact';
    const INTENT_CERTIFICATION = 'certification';
    const INTENT_ABOUT = 'about';
    const INTENT_ARTICLE = 'article';
    const INTENT_HELP = 'help';
    const INTENT_UNKNOWN = 'unknown';

    public function __construct(
        protected ChatbotRuleRepository $ruleRepository,
        protected ChatHistoryRepository $historyRepository
    ) {}

    /**
     * Check rate limit for IP address.
     *
     * @param string $ipAddress
     * @return bool
     */
    public function checkRateLimit(string $ipAddress): bool
    {
        $minuteKey = "chatbot:rate_limit:minute:{$ipAddress}";
        $hourKey = "chatbot:rate_limit:hour:{$ipAddress}";

        // Check per-minute limit
        if (RateLimiter::tooManyAttempts($minuteKey, self::RATE_LIMIT_PER_MINUTE)) {
            return false;
        }

        // Check per-hour limit
        if (RateLimiter::tooManyAttempts($hourKey, self::RATE_LIMIT_PER_HOUR)) {
            return false;
        }

        // Increment rate limit counters
        RateLimiter::hit($minuteKey, 60); // 60 seconds
        RateLimiter::hit($hourKey, 3600); // 3600 seconds (1 hour)

        return true;
    }

    /**
     * Get remaining rate limit attempts.
     *
     * @param string $ipAddress
     * @return array
     */
    public function getRateLimitInfo(string $ipAddress): array
    {
        $minuteKey = "chatbot:rate_limit:minute:{$ipAddress}";
        $hourKey = "chatbot:rate_limit:hour:{$ipAddress}";

        return [
            'remaining_minute' => RateLimiter::remaining($minuteKey, self::RATE_LIMIT_PER_MINUTE),
            'remaining_hour' => RateLimiter::remaining($hourKey, self::RATE_LIMIT_PER_HOUR),
            'retry_after_minute' => RateLimiter::availableIn($minuteKey),
            'retry_after_hour' => RateLimiter::availableIn($hourKey),
        ];
    }

    /**
     * Process user message and return bot response (optimized with caching and rate limiting).
     *
     * @param string $message
     * @param string|null $sessionId
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @param int|null $userId
     * @return array
     */
    public function processMessage(
        string $message,
        ?string $sessionId = null,
        ?string $ipAddress = null,
        ?string $userAgent = null,
        ?int $userId = null
    ): array {
        $message = trim($message);
        
        if (empty($message)) {
            return [
                'response' => 'Please provide a message.',
                'rule_id' => null,
                'session_id' => $sessionId,
            ];
        }

        // Check rate limit if IP address is provided
        if ($ipAddress && !$this->checkRateLimit($ipAddress)) {
            $rateLimitInfo = $this->getRateLimitInfo($ipAddress);
            return [
                'response' => 'Too many requests. Please try again later.',
                'rule_id' => null,
                'session_id' => $sessionId,
                'rate_limit' => $rateLimitInfo,
                'error' => 'rate_limit_exceeded',
            ];
        }

        // Generate session ID if not provided
        if (!$sessionId) {
            $sessionId = $this->generateSessionId();
        }

        // Try to get cached response for exact message match (optional optimization)
        $messageHash = md5(strtolower($message));
        $cacheKey = "chatbot:response:{$messageHash}";
        
        // Note: We don't cache responses by default as messages vary, but we can cache exact matches
        // Uncomment if needed: $cachedResponse = Cache::get($cacheKey);

        // Step 1: Check database rules first
        $rule = $this->ruleRepository->findMatchingRule($message);

        $response = null;
        $ruleId = null;
        $responseType = 'text';
        $extra = [];

        if ($rule) {
            $response = $rule->response;
            $ruleId = $rule->id;
            $responseType = $rule->type ?? 'text';
        } else {
            // Step 2: Detect intent using NLP-like analysis
            $intentData = $this->detectIntent($message);
            $intent = $intentData['intent'];
            $entities = $intentData['entities'];
            $confidence = $intentData['confidence'];

            // Step 3: Process based on detected intent
            $result = $this->processIntent($intent, $entities, $message, $confidence);
            
            $response = $result['response'];
            $responseType = $result['type'] ?? 'text';
            $extra = $result['extra'] ?? [];
        }

        // Save chat history asynchronously (in transaction for data integrity)
        try {
            DB::transaction(function () use ($sessionId, $userId, $message, $response, $ruleId, $ipAddress, $userAgent) {
                $this->historyRepository->create([
                    'session_id' => $sessionId,
                    'user_id' => $userId,
                    'user_message' => $message,
                    'bot_response' => $response,
                    'rule_id' => $ruleId,
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                ]);

                // Clear session cache if history was saved
                $this->historyRepository->clearSessionCache($sessionId);
            });
        } catch (\Exception $e) {
            // Log the error but don't fail the request
            Log::error('Failed to save chat history: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $userId,
                'session_id' => $sessionId,
                'message' => $message
            ]);
        }

        return [
            'response' => $response,
            'rule_id' => $ruleId,
            'session_id' => $sessionId,
            'timestamp' => now()->toISOString(),
            'type' => $responseType,
            'extra' => $extra,
        ];
    }

    /**
     * Detect intent from user message using pattern matching and keyword analysis.
     * Returns intent, extracted entities, and confidence score.
     *
     * @param string $message
     * @return array{intent: string, entities: array, confidence: float}
     */
    protected function detectIntent(string $message): array
    {
        $normalizedMessage = $this->normalizeMessage($message);
        $tokens = $this->tokenize($normalizedMessage);
        
        // Intent patterns with confidence scores
        $intentPatterns = [
            // Greeting patterns (high confidence)
            self::INTENT_GREETING => [
                'patterns' => ['/^(halo|hai|hello|hi|hey|selamat\s*(pagi|siang|sore|malam)|assalamualaikum|apa\s*kabar)/i'],
                'keywords' => ['halo', 'hai', 'hello', 'hi', 'hey', 'selamat', 'pagi', 'siang', 'sore', 'malam'],
                'weight' => 1.0,
            ],
            // Goodbye patterns
            self::INTENT_GOODBYE => [
                'patterns' => ['/\b(bye|goodbye|sampai\s*jumpa|dadah|selamat\s*tinggal)\b/i'],
                'keywords' => ['bye', 'goodbye', 'sampai', 'jumpa', 'dadah'],
                'weight' => 1.0,
            ],
            // Thanks patterns
            self::INTENT_THANKS => [
                'patterns' => ['/\b(terima\s*kasih|thanks|thank\s*you|makasih|trims)\b/i'],
                'keywords' => ['terima', 'kasih', 'thanks', 'makasih', 'trims'],
                'weight' => 1.0,
            ],
            // Product list patterns (user wants to see all products)
            self::INTENT_PRODUCT_LIST => [
                'patterns' => [
                    '/\b(daftar|list|semua|tampilkan|lihat|show)\s*(produk|product)/i',
                    '/\b(produk|product)\s*(apa\s*saja|apa\s*aja|tersedia|yang\s*ada)/i',
                    '/\b(ada|punya)\s*(produk|product)\s*(apa)/i',
                    '/\bjual\s*apa\s*(saja|aja)\b/i',
                ],
                'keywords' => ['daftar', 'list', 'semua', 'tampilkan', 'lihat', 'produk', 'tersedia'],
                'weight' => 0.95,
            ],
            // Featured products
            self::INTENT_PRODUCT_FEATURED => [
                'patterns' => [
                    '/\b(produk|product)\s*(unggulan|terbaik|favorit|populer|best|top)/i',
                    '/\b(rekomendasi|recommend)\s*(produk|product)/i',
                ],
                'keywords' => ['unggulan', 'terbaik', 'favorit', 'populer', 'rekomendasi'],
                'weight' => 0.9,
            ],
            // Product search (user searching for specific product)
            self::INTENT_PRODUCT_SEARCH => [
                'patterns' => [
                    '/\b(cari|search|ada|punya|jual)\s+[a-z]+/i',
                    '/\b(produk|product)\s+[a-z]+/i',
                ],
                'keywords' => ['cari', 'search', 'ada', 'punya', 'jual', 'produk', 'honey', 'madu', 'herbal', 'ginger', 'jahe', 'turmeric', 'kunyit'],
                'weight' => 0.85,
            ],
            // Product price
            self::INTENT_PRODUCT_PRICE => [
                'patterns' => [
                    '/\b(harga|price|berapa)\s*(produk|product)?/i',
                    '/\b(produk|product)\s*(harga|price|berapa)/i',
                ],
                'keywords' => ['harga', 'price', 'berapa', 'biaya', 'cost'],
                'weight' => 0.9,
            ],
            // Order patterns
            self::INTENT_ORDER => [
                'patterns' => [
                    '/\b(cara|bagaimana|gimana)\s*(pesan|order|beli|membeli)/i',
                    '/\b(pesan|order|beli|pembelian|pemesanan)\b/i',
                    '/\b(mau|ingin|pengen)\s*(pesan|beli|order)/i',
                ],
                'keywords' => ['pesan', 'order', 'beli', 'pembelian', 'pemesanan', 'cara', 'bagaimana'],
                'weight' => 0.95,
            ],
            // Contact patterns
            self::INTENT_CONTACT => [
                'patterns' => [
                    '/\b(kontak|contact|hubungi|telepon|telp|phone|whatsapp|wa|alamat|lokasi|address)\b/i',
                    '/\b(informasi|info)\s*(kontak|contact)/i',
                    '/\b(jam|waktu)\s*(operasional|buka|kerja)/i',
                ],
                'keywords' => ['kontak', 'contact', 'hubungi', 'telepon', 'telp', 'whatsapp', 'wa', 'alamat', 'lokasi'],
                'weight' => 0.95,
            ],
            // Certification patterns
            self::INTENT_CERTIFICATION => [
                'patterns' => [
                    '/\b(sertifikat|sertifikasi|certification|halal|bpom)\b/i',
                    '/\b(info|informasi)\s*(sertifikat|sertifikasi|halal|bpom)/i',
                    '/\b(produk)\s*(aman|halal)/i',
                ],
                'keywords' => ['sertifikat', 'sertifikasi', 'halal', 'bpom', 'aman', 'izin'],
                'weight' => 0.95,
            ],
            // About company
            self::INTENT_ABOUT => [
                'patterns' => [
                    '/\b(tentang|about)\s*(perusahaan|company|kami|kita)/i',
                    '/\b(profil|profile|sejarah|history)\s*(perusahaan|company)?/i',
                    '/\b(siapa|apa)\s*(pt\s*lestari|perusahaan\s*ini)/i',
                ],
                'keywords' => ['tentang', 'about', 'profil', 'sejarah', 'perusahaan', 'company'],
                'weight' => 0.9,
            ],
            // Article patterns
            self::INTENT_ARTICLE => [
                'patterns' => [
                    '/\b(artikel|article|berita|news|blog)\b/i',
                    '/\b(baca|read)\s*(artikel|article)/i',
                ],
                'keywords' => ['artikel', 'article', 'berita', 'news', 'blog'],
                'weight' => 0.9,
            ],
            // Help patterns
            self::INTENT_HELP => [
                'patterns' => [
                    '/\b(help|bantuan|bantu|tolong)\b/i',
                    '/\b(bisa|dapat)\s*(apa|bantu)/i',
                ],
                'keywords' => ['help', 'bantuan', 'bantu', 'tolong'],
                'weight' => 0.8,
            ],
        ];

        $bestIntent = self::INTENT_UNKNOWN;
        $bestConfidence = 0.0;
        $extractedEntities = [];

        foreach ($intentPatterns as $intent => $config) {
            $confidence = 0.0;
            
            // Check regex patterns
            foreach ($config['patterns'] as $pattern) {
                if (preg_match($pattern, $normalizedMessage, $matches)) {
                    $confidence = max($confidence, $config['weight']);
                    if (count($matches) > 1) {
                        $extractedEntities = array_merge($extractedEntities, array_slice($matches, 1));
                    }
                }
            }

            // Check keyword matching (additive confidence)
            $keywordMatches = 0;
            foreach ($config['keywords'] as $keyword) {
                if (in_array($keyword, $tokens) || str_contains($normalizedMessage, $keyword)) {
                    $keywordMatches++;
                }
            }
            
            if ($keywordMatches > 0) {
                $keywordConfidence = min(0.3 + ($keywordMatches * 0.15), 0.7);
                $confidence = max($confidence, $keywordConfidence);
            }

            if ($confidence > $bestConfidence) {
                $bestConfidence = $confidence;
                $bestIntent = $intent;
            }
        }

        // Extract product name entities
        $productEntities = $this->extractProductEntities($normalizedMessage);
        $extractedEntities = array_merge($extractedEntities, $productEntities);

        return [
            'intent' => $bestIntent,
            'entities' => array_unique(array_filter($extractedEntities)),
            'confidence' => $bestConfidence,
        ];
    }

    /**
     * Process detected intent and generate appropriate response.
     *
     * @param string $intent
     * @param array $entities
     * @param string $originalMessage
     * @param float $confidence
     * @return array
     */
    protected function processIntent(string $intent, array $entities, string $originalMessage, float $confidence): array
    {
        return match($intent) {
            self::INTENT_GREETING => $this->handleGreeting(),
            self::INTENT_GOODBYE => $this->handleGoodbye(),
            self::INTENT_THANKS => $this->handleThanks(),
            self::INTENT_PRODUCT_LIST => $this->handleProductList(),
            self::INTENT_PRODUCT_FEATURED => $this->handleFeaturedProducts(),
            self::INTENT_PRODUCT_SEARCH => $this->handleProductSearch($entities, $originalMessage),
            self::INTENT_PRODUCT_PRICE => $this->handleProductPrice($entities),
            self::INTENT_ORDER => $this->handleOrder(),
            self::INTENT_CONTACT => $this->handleContact(),
            self::INTENT_CERTIFICATION => $this->handleCertification(),
            self::INTENT_ABOUT => $this->handleAbout(),
            self::INTENT_ARTICLE => $this->handleArticle($entities, $originalMessage),
            self::INTENT_HELP => $this->handleHelp(),
            default => $this->handleUnknown($confidence),
        };
    }

    /**
     * Normalize message for processing.
     */
    protected function normalizeMessage(string $message): string
    {
        $message = strtolower(trim($message));
        $message = preg_replace('/[^\w\s]/u', ' ', $message);
        return preg_replace('/\s+/', ' ', $message);
    }

    /**
     * Tokenize message into words.
     */
    protected function tokenize(string $message): array
    {
        return array_filter(explode(' ', $message), fn($w) => strlen($w) > 1);
    }

    /**
     * Extract potential product name entities from message.
     */
    protected function extractProductEntities(string $message): array
    {
        $productKeywords = ['honey', 'madu', 'ginger', 'jahe', 'turmeric', 'kunyit', 'herbal', 'tea', 'teh', 'organic', 'organik', 'natural', 'alami', 'blend', 'powder', 'bubuk'];
        $found = [];
        
        foreach ($productKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                $found[] = $keyword;
            }
        }
        
        return $found;
    }

    // ===== Intent Handlers =====

    protected function handleGreeting(): array
    {
        $responses = [
            "Halo! 👋 Selamat datang di PT Lestari Jaya Bangsa.\n\nSaya siap membantu Anda dengan informasi tentang produk herbal dan makanan olahan kami. Ada yang bisa saya bantu?",
            "Hai! 😊 Senang bertemu dengan Anda.\n\nSaya bisa membantu informasi tentang:\n📦 Produk kami\n🛒 Cara pemesanan\n🏆 Sertifikasi\n📞 Kontak\n\nApa yang ingin Anda ketahui?",
            "Selamat datang! 🌿\n\nPT Lestari Jaya Bangsa menyediakan produk herbal dan makanan olahan berkualitas. Silakan tanyakan apa saja!",
        ];
        return ['response' => $responses[array_rand($responses)], 'type' => 'text', 'extra' => []];
    }

    protected function handleGoodbye(): array
    {
        $responses = [
            "Sampai jumpa! 👋 Terima kasih telah menghubungi kami. Semoga harimu menyenangkan!",
            "Terima kasih telah berkunjung! Jangan ragu untuk kembali jika ada pertanyaan lain. 😊",
        ];
        return ['response' => $responses[array_rand($responses)], 'type' => 'text', 'extra' => []];
    }

    protected function handleThanks(): array
    {
        $responses = [
            "Sama-sama! 😊 Senang bisa membantu Anda. Jangan ragu untuk bertanya lagi!",
            "Terima kasih kembali! Ada yang lain yang bisa saya bantu?",
        ];
        return ['response' => $responses[array_rand($responses)], 'type' => 'text', 'extra' => []];
    }

    protected function handleProductList(): array
    {
        $products = Product::where('is_active', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('name')
            ->get();

        if ($products->isEmpty()) {
            return [
                'response' => "Maaf, saat ini tidak ada produk yang tersedia. Silakan cek kembali nanti atau hubungi kami.",
                'type' => 'text',
                'extra' => []
            ];
        }

        $productList = $products->map(function ($product) {
            $price = $product->price ? 'Rp ' . number_format($product->price, 0, ',', '.') : 'Hubungi kami';
            $featured = $product->is_featured ? '⭐ ' : '';
            return "{$featured}• {$product->name} - {$price}";
        })->join("\n");

        $response = "📦 **Daftar Produk Kami:**\n\n{$productList}\n\n✨ Semua produk bersertifikat Halal MUI & BPOM\n\nKlik produk di bawah untuk detail:";

        return [
            'response' => $response,
            'type' => 'product_list',
            'extra' => [
                'products' => $products->map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'price' => $p->price,
                    'url' => route('products.show', $p->slug),
                    'image' => $p->getFirstMediaUrl('images') ?: null,
                    'featured' => $p->is_featured,
                ])->toArray()
            ]
        ];
    }

    protected function handleFeaturedProducts(): array
    {
        $products = Product::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('name')
            ->get();

        if ($products->isEmpty()) {
            $products = Product::where('is_active', true)->orderBy('created_at', 'desc')->limit(3)->get();
        }

        if ($products->isEmpty()) {
            return ['response' => "Maaf, tidak ada produk unggulan saat ini.", 'type' => 'text', 'extra' => []];
        }

        $productList = $products->map(fn($p) => "⭐ {$p->name}")->join("\n");

        return [
            'response' => "🏆 **Produk Unggulan Kami:**\n\n{$productList}\n\nProduk-produk terbaik pilihan pelanggan!",
            'type' => 'product_list',
            'extra' => [
                'products' => $products->map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'price' => $p->price,
                    'url' => route('products.show', $p->slug),
                    'image' => $p->getFirstMediaUrl('images') ?: null,
                ])->toArray()
            ]
        ];
    }

    protected function handleProductSearch(array $entities, string $message): array
    {
        // Clean search terms
        $searchTerms = $this->normalizeMessage($message);
        $searchTerms = preg_replace('/\b(cari|search|ada|punya|jual|produk|product|yang|apa|tidak|gak|mau|ingin)\b/', '', $searchTerms);
        $searchTerms = trim(preg_replace('/\s+/', ' ', $searchTerms));

        // Add entities to search
        if (!empty($entities)) {
            $searchTerms = implode(' ', array_merge([$searchTerms], $entities));
        }

        if (strlen($searchTerms) < 2) {
            return $this->handleProductList();
        }

        // Search products
        $products = Product::where('is_active', true)
            ->where(function ($query) use ($searchTerms, $entities) {
                $query->where('name', 'like', "%{$searchTerms}%")
                    ->orWhere('description', 'like', "%{$searchTerms}%");
                
                foreach ($entities as $entity) {
                    $query->orWhere('name', 'like', "%{$entity}%")
                        ->orWhere('description', 'like', "%{$entity}%");
                }
            })
            ->limit(5)
            ->get();

        if ($products->isEmpty()) {
            return [
                'response' => "Maaf, saya tidak menemukan produk \"{$searchTerms}\".\n\n💡 Coba kata kunci lain atau ketik \"daftar produk\" untuk melihat semua produk kami.",
                'type' => 'text',
                'extra' => ['action' => 'no_results', 'search_term' => $searchTerms]
            ];
        }

        $productList = $products->map(function ($p) {
            $price = $p->price ? 'Rp ' . number_format($p->price, 0, ',', '.') : 'Hubungi kami';
            return "• {$p->name} - {$price}";
        })->join("\n");

        return [
            'response' => "🔍 Hasil pencarian untuk \"{$searchTerms}\":\n\n{$productList}",
            'type' => 'product_list',
            'extra' => [
                'products' => $products->map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'price' => $p->price,
                    'url' => route('products.show', $p->slug),
                    'image' => $p->getFirstMediaUrl('images') ?: null,
                ])->toArray()
            ]
        ];
    }

    protected function handleProductPrice(array $entities): array
    {
        if (empty($entities)) {
            $products = Product::where('is_active', true)->orderBy('name')->get();
            
            if ($products->isEmpty()) {
                return ['response' => "Untuk informasi harga, silakan hubungi kami.", 'type' => 'text', 'extra' => []];
            }

            $priceList = $products->map(function ($p) {
                $price = $p->price ? 'Rp ' . number_format($p->price, 0, ',', '.') : 'Hubungi kami';
                return "• {$p->name}: {$price}";
            })->join("\n");

            return [
                'response' => "💰 **Daftar Harga Produk:**\n\n{$priceList}\n\n📞 Untuk pemesanan: (+62) 821-9698-146",
                'type' => 'text',
                'extra' => []
            ];
        }

        return $this->handleProductSearch($entities, implode(' ', $entities));
    }

    protected function handleOrder(): array
    {
        return [
            'response' => "🛒 **Cara Pemesanan:**\n\n1️⃣ **Via WhatsApp** (Tercepat)\n   📱 (+62) 821-9698-146\n\n2️⃣ **Via Formulir Kontak**\n   🌐 " . route('contact') . "\n\n3️⃣ **Datang Langsung**\n   📍 Jl. Raya Buntu - Sampang, Kec. Kebasen, Banyumas\n   ⏰ Jam 07:00 - 16:00 WIB\n\nKami siap melayani Anda! 😊",
            'type' => 'text',
            'extra' => ['action' => 'order', 'whatsapp' => '+628219698146']
        ];
    }

    protected function handleContact(): array
    {
        return [
            'response' => "📞 **Informasi Kontak:**\n\n☎️ Telepon: (+62) 821-9698-146\n💬 WhatsApp: (+62) 821-9698-146\n\n📍 **Alamat:**\nJl. Raya Buntu - Sampang,\nUtara Pasar, Kali Minyak,\nKec. Kebasen, Kab. Banyumas,\nJawa Tengah 53282\n\n⏰ **Jam Operasional:**\nSenin - Sabtu: 07:00 - 16:00 WIB\n\n🌐 Halaman Kontak: " . route('contact'),
            'type' => 'text',
            'extra' => ['action' => 'contact', 'phone' => '+628219698146']
        ];
    }

    protected function handleCertification(): array
    {
        return [
            'response' => "🏆 **Sertifikasi Produk Kami:**\n\n🕌 **Halal MUI**\nSemua produk memenuhi standar syariat Islam dan telah bersertifikat Halal dari Majelis Ulama Indonesia.\n\n🏥 **BPOM**\nTerdaftar dan disetujui oleh Badan Pengawas Obat dan Makanan Indonesia.\n\n🌿 **100% Bahan Alami**\nDibuat dari bahan-bahan alami berkualitas tinggi tanpa bahan kimia berbahaya.\n\n✅ Kami berkomitmen menyediakan produk yang aman dan berkualitas untuk keluarga Indonesia.",
            'type' => 'text',
            'extra' => []
        ];
    }

    protected function handleAbout(): array
    {
        return [
            'response' => "🏢 **Tentang PT Lestari Jaya Bangsa**\n\n📅 Berdiri sejak: **1992**\n🏭 Bidang: **Food & Herbal**\n\n📝 PT Lestari Jaya Bangsa adalah perusahaan yang bergerak di bidang produk herbal dan makanan olahan berkualitas tinggi.\n\nKami berkomitmen untuk:\n✅ Memprioritaskan kesehatan\n✅ Menjaga kualitas rasa\n✅ Menggunakan bahan alami\n✅ Standar sertifikasi tertinggi\n\n🌐 Selengkapnya: " . route('about'),
            'type' => 'text',
            'extra' => []
        ];
    }

    protected function handleArticle(array $entities, string $message): array
    {
        $searchTerms = preg_replace('/\b(artikel|article|berita|news|baca|tentang)\b/i', '', strtolower($message));
        $searchTerms = trim(preg_replace('/\s+/', ' ', $searchTerms));

        $query = Article::where('is_published', true);
        
        if (strlen($searchTerms) > 2) {
            $query->where(function ($q) use ($searchTerms) {
                $q->where('title', 'like', "%{$searchTerms}%")
                    ->orWhere('content', 'like', "%{$searchTerms}%");
            });
        }
        
        $articles = $query->orderBy('published_at', 'desc')->limit(5)->get();

        if ($articles->isEmpty()) {
            return [
                'response' => "📰 Belum ada artikel tersedia saat ini.\n\nKunjungi halaman artikel kami: " . route('articles.index'),
                'type' => 'text',
                'extra' => []
            ];
        }

        $articleList = $articles->map(fn($a) => "📄 {$a->title}")->join("\n");

        return [
            'response' => "📰 **Artikel Terbaru:**\n\n{$articleList}\n\n📖 Baca selengkapnya:",
            'type' => 'article_list',
            'extra' => [
                'articles' => $articles->map(fn($a) => [
                    'id' => $a->id,
                    'title' => $a->title,
                    'slug' => $a->slug,
                    'url' => route('articles.show', $a->slug),
                ])->toArray()
            ]
        ];
    }

    protected function handleHelp(): array
    {
        return [
            'response' => "🤖 **Panduan Chatbot**\n\nSaya bisa membantu Anda dengan:\n\n📦 **Produk**\n   • \"daftar produk\" - lihat semua produk\n   • \"produk unggulan\" - produk terbaik\n   • \"cari [nama]\" - cari produk\n\n🛒 **Pemesanan**\n   • \"cara pesan\" - panduan order\n\n📞 **Kontak**\n   • \"informasi kontak\" - alamat & telepon\n\n🏆 **Lainnya**\n   • \"sertifikasi\" - info halal & BPOM\n   • \"tentang\" - profil perusahaan\n   • \"artikel\" - berita terbaru\n\nKetik atau klik tombol di bawah! 😊",
            'type' => 'text',
            'extra' => []
        ];
    }

    protected function handleUnknown(float $confidence): array
    {
        if ($confidence > 0.3) {
            return [
                'response' => "Hmm, saya kurang yakin dengan maksud Anda. 🤔\n\nCoba tanyakan tentang:\n• Produk kami\n• Cara pemesanan\n• Sertifikasi\n• Kontak\n\nAtau ketik \"bantuan\" untuk panduan lengkap.",
                'type' => 'text',
                'extra' => []
            ];
        }

        $fallbacks = [
            "Maaf, saya tidak mengerti. 😅\n\nBerikut yang bisa saya bantu:\n📦 Produk\n🛒 Pemesanan\n🏆 Sertifikasi\n📞 Kontak\n\nKetik \"bantuan\" untuk panduan.",
            "Saya belum bisa memahami pertanyaan tersebut.\n\nCoba gunakan tombol di bawah atau tanyakan:\n• \"daftar produk\"\n• \"cara pesan\"\n• \"info kontak\"",
        ];

        return ['response' => $fallbacks[array_rand($fallbacks)], 'type' => 'text', 'extra' => []];
    }

    /**
     * Get quick reply suggestions.
     *
     * @return array
     */
    public function getQuickReplies(): array
    {
        return [
            ['text' => '📦 Daftar Produk', 'action' => 'Tampilkan daftar produk'],
            ['text' => '🛒 Cara Pemesanan', 'action' => 'Bagaimana cara memesan produk?'],
            ['text' => '🏆 Sertifikasi', 'action' => 'Info sertifikasi produk'],
            ['text' => '📞 Hubungi Kami', 'action' => 'Informasi kontak'],
            ['text' => '🏢 Tentang Kami', 'action' => 'Tentang perusahaan'],
        ];
    }

    /**
     * Get chat history by session (with caching).
     *
     * @param string $sessionId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChatHistory(string $sessionId)
    {
        return $this->historyRepository->getBySession($sessionId);
    }

    /**
     * Get analytics data (with caching).
     *
     * @param int $days
     * @return array
     */
    public function getAnalytics(int $days = 30)
    {
        return $this->historyRepository->getAnalytics($days);
    }

    /**
     * Generate a unique session ID.
     *
     * @return string
     */
    protected function generateSessionId(): string
    {
        // Use a more secure session ID generation
        return 'chat_' . uniqid('', true) . '_' . time() . '_' . bin2hex(random_bytes(8));
    }

    /**
     * Clear chatbot cache (rules and history).
     *
     * @return void
     */
    public function clearCache(): void
    {
        $this->ruleRepository->clearCache();
        $this->historyRepository->clearCache();
    }

    /**
     * Warm up chatbot cache (pre-load rules).
     *
     * @return void
     */
    public function warmCache(): void
    {
        $this->ruleRepository->warmCache();
    }
}

