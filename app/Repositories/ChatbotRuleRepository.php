<?php

namespace App\Repositories;

use App\Models\ChatbotRule;
use Illuminate\Support\Facades\Cache;

class ChatbotRuleRepository extends BaseRepository
{
    /**
     * Cache key for active rules.
     */
    const CACHE_KEY_ACTIVE_RULES = 'chatbot_rules:active';

    /**
     * Cache TTL in seconds (1 hour).
     */
    const CACHE_TTL = 3600;

    /**
     * Create a new repository instance.
     */
    public function __construct(ChatbotRule $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active rules ordered by priority (cached).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveRules()
    {
        return Cache::remember(
            self::CACHE_KEY_ACTIVE_RULES,
            self::CACHE_TTL,
            function () {
                return $this->newQuery()
                    ->where('status', 'active')
                    ->orderBy('priority', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
            }
        );
    }

    /**
     * Find matching rule by keyword (optimized with caching).
     *
     * @param string $message
     * @return \App\Models\ChatbotRule|null
     */
    public function findMatchingRule(string $message)
    {
        $message = strtolower(trim($message));
        
        if (empty($message)) {
            return null;
        }

        // Get cached active rules (much faster than querying database)
        $rules = $this->getActiveRules();

        // Early return if no rules
        if ($rules->isEmpty()) {
            return null;
        }

        // Check if any keyword appears in the message
        // Rules are already ordered by priority, so first match wins
        foreach ($rules as $rule) {
            $keyword = strtolower(trim($rule->keyword));
            
            // Skip empty keywords
            if (empty($keyword)) {
                continue;
            }

            // Check if keyword appears in message
            if (str_contains($message, $keyword)) {
                return $rule;
            }
        }

        return null;
    }

    /**
     * Find matching rule using database query (for exact or prefix matching).
     * This is more efficient for exact matches but less flexible for "contains" matching.
     *
     * @param string $message
     * @return \App\Models\ChatbotRule|null
     */
    public function findMatchingRuleByQuery(string $message)
    {
        $message = strtolower(trim($message));
        
        if (empty($message)) {
            return null;
        }

        // Try exact match first (most efficient)
        $rule = $this->newQuery()
            ->where('status', 'active')
            ->whereRaw('LOWER(keyword) = ?', [$message])
            ->orderBy('priority', 'asc')
            ->orderBy('id', 'asc')
            ->first();

        if ($rule) {
            return $rule;
        }

        // Try prefix match (keyword starts with message or message starts with keyword)
        $rule = $this->newQuery()
            ->where('status', 'active')
            ->where(function ($query) use ($message) {
                $query->whereRaw('LOWER(keyword) LIKE ?', [$message . '%'])
                      ->orWhereRaw('LOWER(?) LIKE CONCAT(LOWER(keyword), "%")', [$message]);
            })
            ->orderBy('priority', 'asc')
            ->orderBy('id', 'asc')
            ->first();

        return $rule;
    }

    /**
     * Clear cache for active rules.
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY_ACTIVE_RULES);
    }

    /**
     * Warm up cache by pre-loading active rules.
     *
     * @return void
     */
    public function warmCache(): void
    {
        $this->getActiveRules();
    }
}

