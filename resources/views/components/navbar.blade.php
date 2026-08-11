<nav id="navbar"
     x-data="{
         open: false,
         scrolled: false
     }"
     x-init="
         scrolled = window.pageYOffset > 50;
         window.addEventListener('scroll', () => {
             scrolled = window.pageYOffset > 50;
         }, { passive: true });
     "
     :class="scrolled ? 'navbar-scrolled shadow-xl backdrop-blur-xl bg-white/98 dark:bg-neutral-900/98' : 'bg-white/80 dark:bg-neutral-900/80'"
     class="fixed top-0 left-0 right-0 backdrop-blur-lg border-b border-neutral-200/60 dark:border-neutral-800/60 z-50 transition-all duration-500 ease-out">
    <div class="container-custom max-w-7xl">
        <div class="flex justify-between items-center h-16 md:h-20 lg:h-24 transition-all duration-300">
            <!-- Logo -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 md:space-x-4 group" aria-label="PT Lestari Jaya Bangsa Home">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl blur-md opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                        <div class="relative w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 ease-out shadow-xl group-hover:shadow-primary-500/50 border-2 border-white/20">
                            <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-lg md:text-xl lg:text-2xl font-heading font-bold bg-gradient-to-r from-primary-600 via-primary-700 to-primary-800 bg-clip-text text-transparent group-hover:from-primary-700 group-hover:to-primary-900 transition-all duration-300">
                            PT Lestari Jaya Bangsa
                        </span>
                        <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 font-medium hidden lg:block">
                            Food & Herbal
                        </p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-2">
                <a href="{{ route('home') }}" 
                   class="relative px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 ease-out group {{ request()->routeIs('home') ? 'text-primary-700 dark:text-primary-400' : 'text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400' }}">
                    <span class="relative z-10">Beranda</span>
                    @if(request()->routeIs('home'))
                        <span class="absolute inset-0 bg-primary-50 dark:bg-primary-900/30 rounded-xl transform scale-105 transition-transform duration-300"></span>
                    @else
                        <span class="absolute inset-0 bg-primary-50 dark:bg-primary-900/20 rounded-xl opacity-0 group-hover:opacity-100 transform scale-95 group-hover:scale-100 transition-all duration-300"></span>
                    @endif
                </a>
                <a href="{{ route('products.index') }}" 
                   class="relative px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 ease-out group {{ request()->routeIs('products.*') ? 'text-primary-700 dark:text-primary-400' : 'text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400' }}">
                    <span class="relative z-10">Produk</span>
                    @if(request()->routeIs('products.*'))
                        <span class="absolute inset-0 bg-primary-50 dark:bg-primary-900/30 rounded-xl transform scale-105 transition-transform duration-300"></span>
                    @else
                        <span class="absolute inset-0 bg-primary-50 dark:bg-primary-900/20 rounded-xl opacity-0 group-hover:opacity-100 transform scale-95 group-hover:scale-100 transition-all duration-300"></span>
                    @endif
                </a>
                <a href="{{ route('about') }}" 
                   class="relative px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 ease-out group {{ request()->routeIs('about') ? 'text-primary-700 dark:text-primary-400' : 'text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400' }}">
                    <span class="relative z-10">Tentang</span>
                    @if(request()->routeIs('about'))
                        <span class="absolute inset-0 bg-primary-50 dark:bg-primary-900/30 rounded-xl transform scale-105 transition-transform duration-300"></span>
                    @else
                        <span class="absolute inset-0 bg-primary-50 dark:bg-primary-900/20 rounded-xl opacity-0 group-hover:opacity-100 transform scale-95 group-hover:scale-100 transition-all duration-300"></span>
                    @endif
                </a>
                <a href="{{ route('articles.index') }}" 
                   class="relative px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 ease-out group {{ request()->routeIs('articles.*') ? 'text-primary-700 dark:text-primary-400' : 'text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400' }}">
                    <span class="relative z-10">Artikel</span>
                    @if(request()->routeIs('articles.*'))
                        <span class="absolute inset-0 bg-primary-50 dark:bg-primary-900/30 rounded-xl transform scale-105 transition-transform duration-300"></span>
                    @else
                        <span class="absolute inset-0 bg-primary-50 dark:bg-primary-900/20 rounded-xl opacity-0 group-hover:opacity-100 transform scale-95 group-hover:scale-100 transition-all duration-300"></span>
                    @endif
                </a>
                <a href="{{ route('contact') }}" 
                   class="relative px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 ease-out group {{ request()->routeIs('contact') ? 'text-primary-700 dark:text-primary-400' : 'text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400' }}">
                    <span class="relative z-10">Kontak</span>
                    @if(request()->routeIs('contact'))
                        <span class="absolute inset-0 bg-primary-50 dark:bg-primary-900/30 rounded-xl transform scale-105 transition-transform duration-300"></span>
                    @else
                        <span class="absolute inset-0 bg-primary-50 dark:bg-primary-900/20 rounded-xl opacity-0 group-hover:opacity-100 transform scale-95 group-hover:scale-100 transition-all duration-300"></span>
                    @endif
                </a>
            </div>

            <!-- Auth & Mobile Menu Button -->
            <div class="flex items-center space-x-3 md:space-x-4">
                @auth
                    <a href="{{ route('admin.dashboard') }}" 
                       class="hidden md:flex btn btn-primary text-sm shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="hidden md:flex btn btn-outline text-sm border-primary-600 hover:border-primary-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Login
                    </a>
                @endauth

                <!-- Mobile menu button -->
                <button @click="open = !open"
                        class="lg:hidden relative p-2.5 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 active:scale-95"
                        aria-label="Toggle menu"
                        aria-expanded="false"
                        :aria-expanded="open.toString()">
                    <div class="relative w-6 h-6">
                        <svg x-show="!open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 rotate-90" x-transition:enter-end="opacity-100 rotate-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 rotate-0" x-transition:leave-end="opacity-0 -rotate-90" class="absolute inset-0 w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -rotate-90" x-transition:enter-end="opacity-100 rotate-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 rotate-0" x-transition:leave-end="opacity-0 rotate-90" class="absolute inset-0 w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="open" 
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden py-6 border-t border-neutral-200/60 dark:border-neutral-800/60 bg-gradient-to-b from-white/95 to-white dark:from-neutral-900/95 dark:to-neutral-900 backdrop-blur-xl">
            <div class="flex flex-col space-y-2">
                <a href="{{ route('home') }}" 
                   class="relative px-5 py-3.5 rounded-xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('home') ? 'text-primary-700 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30' : 'text-neutral-700 dark:text-neutral-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400' }}"
                   @click="open = false">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Beranda
                    </span>
                </a>
                <a href="{{ route('products.index') }}" 
                   class="relative px-5 py-3.5 rounded-xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('products.*') ? 'text-primary-700 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30' : 'text-neutral-700 dark:text-neutral-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400' }}"
                   @click="open = false">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Produk
                    </span>
                </a>
                <a href="{{ route('about') }}" 
                   class="relative px-5 py-3.5 rounded-xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('about') ? 'text-primary-700 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30' : 'text-neutral-700 dark:text-neutral-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400' }}"
                   @click="open = false">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tentang
                    </span>
                </a>
                <a href="{{ route('articles.index') }}" 
                   class="relative px-5 py-3.5 rounded-xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('articles.*') ? 'text-primary-700 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30' : 'text-neutral-700 dark:text-neutral-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400' }}"
                   @click="open = false">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        Artikel
                    </span>
                </a>
                <a href="{{ route('contact') }}" 
                   class="relative px-5 py-3.5 rounded-xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('contact') ? 'text-primary-700 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30' : 'text-neutral-700 dark:text-neutral-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400' }}"
                   @click="open = false">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Kontak
                    </span>
                </a>
                <div class="pt-4 mt-4 border-t border-neutral-200 dark:border-neutral-800">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center justify-center w-full px-5 py-3.5 rounded-xl text-base font-semibold btn-primary"
                           @click="open = false">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="flex items-center justify-center w-full px-5 py-3.5 rounded-xl text-base font-semibold btn-outline"
                           @click="open = false">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    [x-cloak] { display: none !important; }
</style>
