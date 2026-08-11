<!-- Modern Chatbot Widget with Alpine.js -->
<div x-data="{
    open: false,
    messages: [],
    isLoading: false,
    inputText: ''
}"
x-init="
    messages.push({
        type: 'bot',
        text: 'Halo! Saya di sini untuk membantu Anda dengan informasi tentang produk dan layanan kami. Ada yang bisa saya bantu?',
        time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
    });
"
x-cloak
class="fixed bottom-6 right-6 z-50">

    <!-- Chat Button -->
    <button @click="open = !open"
            class="bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-full w-16 h-16 md:w-20 md:h-20 flex items-center justify-center cursor-pointer shadow-2xl hover:shadow-primary-500/50 transform hover:scale-110 transition-all duration-300 pulse-ring relative"
            :class="{ 'animate-pulse': !open }"
            aria-label="Open chat">

        <!-- Notification Badge (if closed and has unread messages) -->
        <span x-show="!open && messages.length > 1"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="scale-0 opacity-0"
              x-transition:enter-end="scale-100 opacity-100"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold">
            <span x-text="messages.length - 1"></span>
        </span>

        <!-- Chat Icon -->
        <svg x-show="!open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-50"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-50"
             class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>

        <!-- Close Icon -->
        <svg x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-50 rotate-90"
             x-transition:enter-end="opacity-100 scale-100 rotate-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 rotate-0"
             x-transition:leave-end="opacity-0 scale-50 rotate-90"
             class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Chat Window -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="absolute bottom-24 right-0 w-96 max-w-[calc(100vw-2rem)] bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl border border-neutral-200 dark:border-neutral-700 overflow-hidden"
         @click.away="open = false">

        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white p-4 md:p-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">PT Lestari Jaya Bangsa</h3>
                        <p class="text-sm text-white/90">Customer Support</p>
                    </div>
                </div>
                <button @click="open = false"
                        class="text-white/80 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Container -->
        <div x-ref="messagesContainer"
             class="h-96 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-neutral-900">

            <template x-for="(message, index) in messages" :key="index">
                <div class="flex items-start space-x-3"
                     :class="message.type === 'user' ? 'justify-end' : 'justify-start'">

                    <!-- Avatar -->
                    <div x-show="message.type === 'bot'"
                         class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>

                    <!-- Message Bubble -->
                    <div class="max-w-xs md:max-w-md"
                         :class="message.type === 'user' ? 'order-2' : 'order-1'">
                        <div class="rounded-2xl px-4 py-3 shadow-sm"
                             :class="message.type === 'user'
                                 ? 'bg-primary-600 text-white rounded-br-none'
                                 : 'bg-white dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 rounded-bl-none border border-neutral-200 dark:border-neutral-700'">
                            <p class="text-sm leading-relaxed" x-text="message.text"></p>
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 px-2"
                           :class="message.type === 'user' ? 'text-right' : 'text-left'"
                           x-text="message.time"></p>
                    </div>

                    <!-- User Avatar -->
                    <div x-show="message.type === 'user'"
                         class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center flex-shrink-0 order-1">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isLoading"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <div class="bg-white dark:bg-neutral-800 rounded-2xl rounded-bl-none px-4 py-3 shadow-sm border border-neutral-200 dark:border-neutral-700">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-neutral-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-neutral-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-neutral-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white dark:bg-neutral-800 border-t border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center space-x-2">
                <input x-ref="input"
                       x-model="inputText"
                       @keydown.enter="if (inputText.trim() && !isLoading) {
                           messages.push({
                               type: 'user',
                               text: inputText.trim(),
                               time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                           });
                           const userMsg = inputText.trim();
                           inputText = '';
                           isLoading = true;

                           // Simulate bot response
                           setTimeout(() => {
                               isLoading = false;
                               messages.push({
                                   type: 'bot',
                                   text: 'Terima kasih atas pesan Anda. Kami akan segera merespons.',
                                   time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                               });
                           }, 1000);
                       }"
                       type="text"
                       placeholder="Ketik pesan Anda..."
                       :disabled="isLoading"
                       class="flex-1 px-4 py-3 bg-gray-50 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent disabled:opacity-50 disabled:cursor-not-allowed">

                <button @click="if (inputText.trim() && !isLoading) {
                           messages.push({
                               type: 'user',
                               text: inputText.trim(),
                               time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                           });
                           const userMsg = inputText.trim();
                           inputText = '';
                           isLoading = true;

                           // Simulate bot response
                           setTimeout(() => {
                               isLoading = false;
                               messages.push({
                                   type: 'bot',
                                   text: 'Terima kasih atas pesan Anda. Kami akan segera merespons.',
                                   time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                               });
                           }, 1000);
                       }"
                        :disabled="isLoading || !inputText.trim()"
                        class="bg-primary-600 hover:bg-primary-700 disabled:bg-neutral-300 dark:disabled:bg-neutral-600 text-white p-3 rounded-xl transition-colors duration-200 disabled:cursor-not-allowed transform hover:scale-105 active:scale-95">

                    <!-- Send Icon -->
                    <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>

                    <!-- Loading Spinner -->
                    <svg x-show="isLoading" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>

            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2 mt-3">
                <button @click="inputText = 'Daftar produk';
                           messages.push({
                               type: 'user',
                               text: inputText,
                               time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                           });
                           inputText = '';
                           isLoading = true;
                           setTimeout(() => {
                               isLoading = false;
                               messages.push({
                                   type: 'bot',
                                   text: 'Berikut adalah daftar produk kami. Silakan kunjungi halaman produk untuk informasi lengkap.',
                                   time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                               });
                           }, 1000);"
                        class="text-xs px-3 py-1.5 bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 rounded-full hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors">
                    📦 Daftar Produk
                </button>
                <button @click="inputText = 'Cara pemesanan';
                           messages.push({
                               type: 'user',
                               text: inputText,
                               time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                           });
                           inputText = '';
                           isLoading = true;
                           setTimeout(() => {
                               isLoading = false;
                               messages.push({
                                   type: 'bot',
                                   text: 'Untuk pemesanan, silakan hubungi kami melalui halaman kontak atau WhatsApp di (+62) 821-9698-146.',
                                   time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                               });
                           }, 1000);"
                        class="text-xs px-3 py-1.5 bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 rounded-full hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors">
                    🛒 Cara Pemesanan
                </button>
                <button @click="inputText = 'Info sertifikasi';
                           messages.push({
                               type: 'user',
                               text: inputText,
                               time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                           });
                           inputText = '';
                           isLoading = true;
                           setTimeout(() => {
                               isLoading = false;
                               messages.push({
                                   type: 'bot',
                                   text: 'Semua produk kami telah tersertifikasi Halal MUI dan terdaftar di BPOM, menjamin kualitas dan keamanan.',
                                   time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                               });
                           }, 1000);"
                        class="text-xs px-3 py-1.5 bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 rounded-full hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors">
                    🏆 Sertifikasi
                </button>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>