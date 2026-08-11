{{-- Enhanced Chatbot Widget with Product Search & Session Persistence --}}
<div x-data="chatbotWidget()" 
     x-init="init()"
     class="fixed bottom-6 right-6 z-50"
     id="chatbot-widget">
    
    {{-- Chat Window --}}
    <div x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 transform translate-y-4 scale-95"
         class="absolute bottom-20 right-0 bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl w-[340px] sm:w-[380px] md:w-[400px] h-[520px] md:h-[580px] flex flex-col overflow-hidden border border-neutral-200 dark:border-neutral-700">
        
        {{-- Header --}}
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white p-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-sm">PT Lestari Jaya Bangsa</h3>
                    <p class="text-xs text-primary-100 flex items-center">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></span>
                        Online - Siap membantu
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-1">
                <button @click="clearChat()" 
                        class="text-white/70 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors"
                        title="Hapus percakapan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
                <button @click="open = false" 
                        class="text-white/70 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors"
                        title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Messages Container --}}
        <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-gradient-to-b from-neutral-50 to-white dark:from-neutral-900 dark:to-neutral-800" 
             x-ref="messagesContainer"
             id="chatMessages">
            
            <template x-for="(message, index) in messages" :key="index">
                <div :class="message.type === 'user' ? 'flex justify-end' : 'flex justify-start'" 
                     class="animate-fade-in-up">
                    
                    {{-- Bot Avatar --}}
                    <div x-show="message.type === 'bot'" class="flex-shrink-0 mr-2">
                        <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Message Content --}}
                    <div class="max-w-[85%]">
                        <div :class="message.type === 'user' 
                            ? 'bg-primary-600 text-white rounded-2xl rounded-tr-sm' 
                            : 'bg-white dark:bg-neutral-700 text-neutral-800 dark:text-neutral-100 rounded-2xl rounded-tl-sm shadow-sm border border-neutral-100 dark:border-neutral-600'"
                             class="px-4 py-2.5">
                            <p class="text-sm whitespace-pre-line" x-html="formatMessage(message.text)"></p>
                        </div>
                        
                        {{-- Product Cards --}}
                        <template x-if="message.extra && message.extra.products && message.extra.products.length > 0">
                            <div class="mt-3 space-y-2">
                                <template x-for="product in message.extra.products" :key="product.id">
                                    <a :href="product.url" 
                                       class="flex items-center p-3 bg-white dark:bg-neutral-700 rounded-xl border border-neutral-200 dark:border-neutral-600 hover:border-primary-300 dark:hover:border-primary-600 hover:shadow-md transition-all group">
                                        <div class="w-12 h-12 bg-primary-50 dark:bg-primary-900/30 rounded-lg flex items-center justify-center flex-shrink-0 mr-3 overflow-hidden">
                                            <template x-if="product.image">
                                                <img :src="product.image" :alt="product.name" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!product.image">
                                                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            </template>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-neutral-800 dark:text-neutral-100 truncate group-hover:text-primary-600 dark:group-hover:text-primary-400" x-text="product.name"></p>
                                            <p class="text-xs text-primary-600 dark:text-primary-400 font-medium" x-text="product.price ? 'Rp ' + new Intl.NumberFormat('id-ID').format(product.price) : 'Hubungi kami'"></p>
                                        </div>
                                        <svg class="w-5 h-5 text-neutral-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </template>
                            </div>
                        </template>

                        {{-- Article Cards --}}
                        <template x-if="message.extra && message.extra.articles && message.extra.articles.length > 0">
                            <div class="mt-3 space-y-2">
                                <template x-for="article in message.extra.articles" :key="article.id">
                                    <a :href="article.url" 
                                       class="flex items-center p-3 bg-white dark:bg-neutral-700 rounded-xl border border-neutral-200 dark:border-neutral-600 hover:border-primary-300 dark:hover:border-primary-600 hover:shadow-md transition-all group">
                                        <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0 mr-3">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-neutral-800 dark:text-neutral-100 truncate group-hover:text-primary-600 dark:group-hover:text-primary-400" x-text="article.title"></p>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Baca artikel</p>
                                        </div>
                                        <svg class="w-5 h-5 text-neutral-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </template>
                            </div>
                        </template>

                        <span class="text-[10px] text-neutral-400 dark:text-neutral-500 mt-1 block px-1" 
                              :class="message.type === 'user' ? 'text-right' : 'text-left'"
                              x-text="message.time"></span>
                    </div>

                    {{-- User Avatar --}}
                    <div x-show="message.type === 'user'" class="flex-shrink-0 ml-2">
                        <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </template>
            
            {{-- Loading Indicator --}}
            <div x-show="isLoading" class="flex justify-start animate-fade-in">
                <div class="flex-shrink-0 mr-2">
                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                </div>
                <div class="bg-white dark:bg-neutral-700 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm border border-neutral-100 dark:border-neutral-600">
                    <div class="flex space-x-1.5">
                        <div class="w-2 h-2 bg-primary-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-primary-400 rounded-full animate-bounce" style="animation-delay: 0.15s"></div>
                        <div class="w-2 h-2 bg-primary-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Replies --}}
        <div class="px-4 py-2 bg-neutral-50 dark:bg-neutral-800/50 border-t border-neutral-100 dark:border-neutral-700 flex-shrink-0">
            <div class="flex flex-wrap gap-2">
                <button @click="sendQuickReply('Tampilkan daftar produk')"
                        class="text-xs px-3 py-1.5 bg-white dark:bg-neutral-700 text-primary-700 dark:text-primary-400 rounded-full border border-primary-200 dark:border-primary-800 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:border-primary-300 dark:hover:border-primary-700 transition-all">
                    📦 Produk
                </button>
                <button @click="sendQuickReply('Bagaimana cara memesan?')"
                        class="text-xs px-3 py-1.5 bg-white dark:bg-neutral-700 text-primary-700 dark:text-primary-400 rounded-full border border-primary-200 dark:border-primary-800 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:border-primary-300 dark:hover:border-primary-700 transition-all">
                    🛒 Pemesanan
                </button>
                <button @click="sendQuickReply('Info sertifikasi')"
                        class="text-xs px-3 py-1.5 bg-white dark:bg-neutral-700 text-primary-700 dark:text-primary-400 rounded-full border border-primary-200 dark:border-primary-800 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:border-primary-300 dark:hover:border-primary-700 transition-all">
                    🏆 Sertifikasi
                </button>
                <button @click="sendQuickReply('Informasi kontak')"
                        class="text-xs px-3 py-1.5 bg-white dark:bg-neutral-700 text-primary-700 dark:text-primary-400 rounded-full border border-primary-200 dark:border-primary-800 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:border-primary-300 dark:hover:border-primary-700 transition-all">
                    📞 Kontak
                </button>
            </div>
        </div>

        {{-- Input Area --}}
        <div class="border-t border-neutral-200 dark:border-neutral-700 p-3 bg-white dark:bg-neutral-800 flex-shrink-0">
            <form @submit.prevent="sendMessage()" class="flex items-center space-x-2">
                <input 
                    type="text" 
                    x-ref="messageInput"
                    x-model="inputText"
                    placeholder="Ketik pesan Anda..."
                    :disabled="isLoading"
                    class="flex-1 px-4 py-2.5 border border-neutral-200 dark:border-neutral-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-700 dark:text-neutral-100 text-sm disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                    autocomplete="off">
                <button 
                    type="submit"
                    :disabled="isLoading || !inputText.trim()"
                    class="p-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 disabled:bg-neutral-300 dark:disabled:bg-neutral-600 disabled:cursor-not-allowed transition-all transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg">
                    <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    <svg x-show="isLoading" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- Floating Button --}}
    <button
        @click="toggleChat()"
        class="relative bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-full w-14 h-14 md:w-16 md:h-16 flex items-center justify-center cursor-pointer shadow-2xl hover:shadow-primary-500/40 transform hover:scale-110 transition-all duration-300"
        aria-label="Toggle chat">
        
        {{-- Notification Badge --}}
        <span x-show="!open && unreadCount > 0"
              x-transition
              class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-bounce">
            <span x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
        </span>

        {{-- Pulse Ring --}}
        <span x-show="!open" class="absolute inset-0 rounded-full bg-primary-500 animate-ping opacity-25"></span>
        
        {{-- Chat Icon --}}
        <svg x-show="!open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 rotate-90 scale-50"
             x-transition:enter-end="opacity-100 rotate-0 scale-100"
             class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        
        {{-- Close Icon --}}
        <svg x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -rotate-90 scale-50"
             x-transition:enter-end="opacity-100 rotate-0 scale-100"
             class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<script>
function chatbotWidget() {
    return {
        open: false,
        messages: [],
        inputText: '',
        isLoading: false,
        unreadCount: 0,
        sessionId: null,

        init() {
            // Load session from localStorage
            this.loadSession();
            
            // Add welcome message if no messages
            if (this.messages.length === 0) {
                this.messages.push({
                    type: 'bot',
                    text: 'Halo! 👋 Selamat datang di PT Lestari Jaya Bangsa.\n\nSaya siap membantu Anda dengan informasi tentang produk herbal dan makanan olahan kami. Ada yang bisa saya bantu?',
                    time: this.getCurrentTime(),
                    extra: {}
                });
            }

            // Watch for open state changes
            this.$watch('open', (value) => {
                if (value) {
                    this.unreadCount = 0;
                    this.$nextTick(() => this.scrollToBottom());
                }
                this.saveSession();
            });
        },

        toggleChat() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => {
                    this.$refs.messageInput?.focus();
                    this.scrollToBottom();
                });
            }
        },

        async sendMessage() {
            const message = this.inputText.trim();
            if (!message || this.isLoading) return;

            // Add user message
            this.messages.push({
                type: 'user',
                text: message,
                time: this.getCurrentTime(),
                extra: {}
            });

            this.inputText = '';
            this.isLoading = true;
            this.scrollToBottom();

            try {
                const response = await fetch('{{ route("chatbot.message") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        message: message,
                        session_id: this.sessionId 
                    })
                });

                const data = await response.json();

                // Store session ID
                if (data.session_id) {
                    this.sessionId = data.session_id;
                }

                // Add bot response
                this.messages.push({
                    type: 'bot',
                    text: data.response || 'Maaf, terjadi kesalahan. Silakan coba lagi.',
                    time: this.getCurrentTime(),
                    extra: data.extra || {}
                });

                // Increment unread if chat is closed
                if (!this.open) {
                    this.unreadCount++;
                }

            } catch (error) {
                console.error('Chatbot error:', error);
                this.messages.push({
                    type: 'bot',
                    text: 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi.',
                    time: this.getCurrentTime(),
                    extra: {}
                });
            }

            this.isLoading = false;
            this.saveSession();
            this.$nextTick(() => this.scrollToBottom());
        },

        sendQuickReply(text) {
            this.inputText = text;
            this.sendMessage();
        },

        clearChat() {
            if (confirm('Hapus semua percakapan?')) {
                this.messages = [{
                    type: 'bot',
                    text: 'Percakapan telah dihapus. Ada yang bisa saya bantu?',
                    time: this.getCurrentTime(),
                    extra: {}
                }];
                this.sessionId = null;
                this.saveSession();
            }
        },

        formatMessage(text) {
            if (!text) return '';
            // Convert URLs to clickable links
            const urlRegex = /(https?:\/\/[^\s]+)/g;
            return text.replace(urlRegex, '<a href="$1" target="_blank" class="text-primary-400 hover:text-primary-300 underline">$1</a>');
        },

        getCurrentTime() {
            return new Date().toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
        },

        scrollToBottom() {
            const container = this.$refs.messagesContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },

        saveSession() {
            try {
                localStorage.setItem('chatbot_session', JSON.stringify({
                    messages: this.messages.slice(-50), // Keep last 50 messages
                    sessionId: this.sessionId,
                    timestamp: Date.now()
                }));
            } catch (e) {
                console.warn('Could not save chat session:', e);
            }
        },

        loadSession() {
            try {
                const saved = localStorage.getItem('chatbot_session');
                if (saved) {
                    const data = JSON.parse(saved);
                    // Only restore if session is less than 24 hours old
                    if (data.timestamp && (Date.now() - data.timestamp) < 86400000) {
                        this.messages = data.messages || [];
                        this.sessionId = data.sessionId;
                    }
                }
            } catch (e) {
                console.warn('Could not load chat session:', e);
            }
        }
    };
}
</script>

<style>
[x-cloak] { display: none !important; }

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.3s ease-out;
}

.animate-fade-in {
    animation: fade-in-up 0.2s ease-out;
}
</style>
