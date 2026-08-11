<x-frontend-layout>
    <x-slot name="title">Beranda - PT Lestari Jaya Bangsa</x-slot>
    <x-slot name="metaDescription">PT Lestari Jaya Bangsa menyediakan produk herbal dan makanan olahan berkualitas tinggi, berkomitmen memprioritaskan kesehatan dan rasa. Berdiri sejak 1992.</x-slot>

    <!-- Hero Section - Modern Design -->
    <section class="relative min-h-screen md:min-h-[90vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Gradient Orbs with enhanced animation -->
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-400/30 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl animate-float-slow float-delay-1"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-white/10 rounded-full blur-2xl animate-float-slow float-delay-2"></div>

            <!-- Enhanced Grid Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0 bg-grid-pattern"></div>
            </div>

            <!-- Decorative Elements with enhanced animation -->
            <div class="absolute top-20 right-20 w-32 h-32 border-2 border-white/10 rounded-full animate-float-slow float-delay-3"></div>
            <div class="absolute bottom-20 left-20 w-24 h-24 border-2 border-white/10 rounded-full animate-float-slow float-delay-4"></div>

            <!-- Floating particles -->
            <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-white/20 rounded-full animate-float-particle float-delay-1"></div>
            <div class="absolute top-3/4 right-1/3 w-3 h-3 bg-white/15 rounded-full animate-float-particle float-delay-2"></div>
            <div class="absolute top-1/2 right-1/4 w-5 h-5 bg-white/10 rounded-full animate-float-particle float-delay-3"></div>
        </div>
        
        <!-- Content -->
        <div class="container-custom relative z-10 py-20 md:py-32 lg:py-40">
            <div class="text-center max-w-5xl mx-auto">
                <!-- Badge -->
                <div class="inline-block mb-8 animate-fade-in-up">
                    <span class="inline-flex items-center px-6 py-2.5 rounded-full text-sm md:text-base font-semibold bg-white/20 backdrop-blur-md text-white border border-white/30 shadow-lg hover:bg-white/30 transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                        Berdiri Sejak 1992
                    </span>
                </div>
                
                <!-- Main Heading -->
                <h1 class="heading-primary text-white mb-8 text-shadow-lg animate-fade-in-up" style="animation-delay: 0.1s;">
                    <span class="block mb-2">Kesehatan dan Rasa,</span>
                    <span class="block bg-gradient-to-r from-white via-primary-100 to-white bg-clip-text text-transparent animate-gradient-x">
                        Dalam Satu Pilihan.
                    </span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-xl md:text-2xl lg:text-3xl font-semibold text-white/95 mb-6 max-w-3xl mx-auto leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s;">
                    Food & Herbal — Menyediakan produk herbal dan makanan olahan berkualitas tinggi
                </p>
                <p class="text-lg md:text-xl text-white/85 mb-12 max-w-4xl mx-auto leading-relaxed animate-fade-in-up" style="animation-delay: 0.3s;">
                    Berkomitmen memprioritaskan kesehatan dan rasa. Dengan pengalaman dan inovasi, perusahaan terus meraih kepercayaan konsumen sambil memperluas jangkauan ke pasar global.
                </p>
                
                <!-- CTA Buttons with enhanced animations -->
                <div class="flex flex-col sm:flex-row gap-4 md:gap-6 justify-center items-center animate-fade-in-up" style="animation-delay: 0.4s;">
                    <a href="{{ route('products.index') }}"
                       class="group relative inline-flex items-center justify-center px-8 py-4 md:px-10 md:py-5 rounded-2xl bg-white text-primary-700 font-bold text-base md:text-lg shadow-2xl hover:shadow-primary-500/30 transform hover:-translate-y-2 hover:scale-105 active:scale-100 transition-all duration-300 overflow-hidden btn-animated">
                        <span class="relative z-10 flex items-center">
                            <span>Lihat Produk Kami</span>
                            <svg class="w-5 h-5 md:w-6 md:h-6 ml-3 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    <a href="{{ route('contact') }}"
                       class="group relative inline-flex items-center justify-center px-8 py-4 md:px-10 md:py-5 rounded-2xl border-2 border-white text-white font-bold text-base md:text-lg backdrop-blur-md bg-white/10 hover:bg-white hover:text-primary-700 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 hover:scale-105 active:scale-100 transition-all duration-300 btn-animated">
                        <span class="relative z-10">Hubungi Kami</span>
                        <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 md:gap-8 mt-16 md:mt-20 max-w-3xl mx-auto animate-fade-in-up" style="animation-delay: 0.5s;">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-2">30+</div>
                        <div class="text-sm md:text-base text-white/80 font-medium">Tahun Pengalaman</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-2">100%</div>
                        <div class="text-sm md:text-base text-white/80 font-medium">Produk Alami</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-2">✓</div>
                        <div class="text-sm md:text-base text-white/80 font-medium">Halal & BPOM</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 animate-bounce">
            <a href="#about" class="flex flex-col items-center text-white/80 hover:text-white transition-colors duration-300 group">
                <span class="text-xs font-semibold mb-2 uppercase tracking-wider">Scroll</span>
                <svg class="w-6 h-6 transform group-hover:translate-y-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- About Preview Section - Modern Design -->
    <section id="about" class="section bg-white dark:bg-neutral-50 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(16, 185, 129, 0.3) 1px, transparent 0); background-size: 60px 60px;"></div>
        </div>
        
        <div class="container-custom relative z-10 max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Image -->
                <div class="relative group order-2 lg:order-1">
                    <div class="absolute -inset-4 bg-gradient-to-br from-primary-200 via-primary-300 to-primary-400 rounded-3xl transform rotate-6 group-hover:rotate-12 transition-transform duration-700 opacity-20 blur-2xl"></div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-400/20 to-primary-600/20 rounded-3xl transform -rotate-3 group-hover:-rotate-6 transition-transform duration-500"></div>
                        <div class="relative bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 rounded-3xl overflow-hidden aspect-[4/3] shadow-2xl border-4 border-white dark:border-neutral-800">
                            <!-- Placeholder for company image -->
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 via-primary-50 to-white dark:from-primary-900/30 dark:via-primary-800/20 dark:to-neutral-800">
                                <div class="text-center p-8">
                                    <svg class="w-32 h-32 md:w-40 md:h-40 text-primary-400 dark:text-primary-500 mx-auto mb-4 transform group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">PT Lestari Jaya Bangsa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="order-1 lg:order-2 animate-fade-in-right">
                    <div class="inline-flex items-center mb-6 px-4 py-2 rounded-full bg-primary-50 dark:bg-primary-900/30 border border-primary-200 dark:border-primary-800">
                        <svg class="w-4 h-4 mr-2 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-primary-700 dark:text-primary-300">Tentang Kami</span>
                    </div>
                    <h2 class="heading-secondary text-neutral-900 dark:text-neutral-100 mb-6 leading-tight">
                        Profil Perusahaan
                    </h2>
                    <p class="text-body mb-6 text-neutral-700 dark:text-neutral-300">
                        PT Lestari Jaya Bangsa adalah perusahaan yang bergerak di bidang <strong class="text-primary-700 dark:text-primary-400">Food & Herbal</strong>, dengan komitmen untuk menyediakan produk berkualitas tinggi yang memprioritaskan kesehatan dan rasa. Sejak didirikan pada tahun 1992, kami telah mengembangkan berbagai produk herbal dan makanan olahan yang telah mendapatkan kepercayaan dari konsumen.
                    </p>
                    <p class="text-body mb-8 text-neutral-700 dark:text-neutral-300">
                        Dengan pengalaman lebih dari <strong class="text-primary-700 dark:text-primary-400">30 tahun</strong>, kami terus berinovasi dan meningkatkan kualitas produk sambil memperluas jangkauan pasar, baik nasional maupun internasional.
                    </p>
                    <div class="flex flex-wrap gap-4 mb-8">
                        <div class="flex items-center px-4 py-2 rounded-xl bg-primary-50 dark:bg-primary-900/30 border border-primary-200 dark:border-primary-800">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm font-semibold text-primary-700 dark:text-primary-300">Produk Berkualitas</span>
                        </div>
                        <div class="flex items-center px-4 py-2 rounded-xl bg-primary-50 dark:bg-primary-900/30 border border-primary-200 dark:border-primary-800">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm font-semibold text-primary-700 dark:text-primary-300">Bersertifikat</span>
                        </div>
                    </div>
                    <a href="{{ route('about') }}" class="group inline-flex items-center btn btn-primary">
                        <span>Selengkapnya</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Certifications Section - Modern Design -->
    <section class="section bg-gradient-to-br from-primary-50 via-white to-primary-50 dark:from-primary-900/10 dark:via-neutral-900 dark:to-primary-900/10 relative overflow-hidden">
        <!-- Decorative Background -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%2310b981\" fill-opacity=\"0.1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="container-custom relative z-10 max-w-7xl">
            <div class="text-center mb-16 animate-fade-in-up">
                <div class="inline-flex items-center mb-4 px-4 py-2 rounded-full bg-primary-100 dark:bg-primary-900/30 border border-primary-200 dark:border-primary-800">
                    <svg class="w-4 h-4 mr-2 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-primary-700 dark:text-primary-300">Sertifikasi & Kepercayaan</span>
                </div>
                <h2 class="heading-secondary text-neutral-900 dark:text-neutral-100 mb-6">
                    Standar Kualitas Tertinggi
                </h2>
                <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-400 max-w-3xl mx-auto leading-relaxed">
                    Kami menjaga standar kualitas dan keamanan tertinggi dalam semua produk kami dengan sertifikasi resmi dan bahan-bahan alami berkualitas tinggi
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <!-- Halal Certification -->
                <div class="group relative card-premium text-center p-8 md:p-10 hover-lift animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                    <div class="relative z-10">
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-primary-200 dark:bg-primary-800 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center mx-auto text-5xl shadow-xl transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                🕌
                            </div>
                        </div>
                        <h3 class="text-2xl font-heading font-bold text-neutral-900 dark:text-neutral-100 mb-4">
                            Halal MUI Certified
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                            Semua produk kami memenuhi persyaratan diet Islam dan telah bersertifikat Halal dari MUI
                        </p>
                    </div>
                </div>

                <!-- BPOM Certification -->
                <div class="group relative card-premium text-center p-8 md:p-10 hover-lift animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                    <div class="relative z-10">
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-primary-200 dark:bg-primary-800 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center mx-auto text-5xl shadow-xl transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                🏥
                            </div>
                        </div>
                        <h3 class="text-2xl font-heading font-bold text-neutral-900 dark:text-neutral-100 mb-4">
                            BPOM Approved
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                            Terdaftar dan disetujui oleh Badan Pengawas Obat dan Makanan Indonesia untuk keamanan produk
                        </p>
                    </div>
                </div>

                <!-- Natural Ingredients -->
                <div class="group relative card-premium text-center p-8 md:p-10 hover-lift animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                    <div class="relative z-10">
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-primary-200 dark:bg-primary-800 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center mx-auto text-5xl shadow-xl transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                🌿
                            </div>
                        </div>
                        <h3 class="text-2xl font-heading font-bold text-neutral-900 dark:text-neutral-100 mb-4">
                            100% Alami
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                            Dibuat dengan bahan-bahan alami berkualitas tinggi tanpa bahan kimia berbahaya
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Highlight Section - Modern Design -->
    @if(isset($featuredProducts) && $featuredProducts->count() > 0)
    <section class="section bg-white dark:bg-neutral-50 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(16, 185, 129, 0.3) 1px, transparent 0); background-size: 60px 60px;"></div>
        </div>
        
        <div class="container-custom relative z-10 max-w-7xl">
            <div class="text-center mb-16 animate-fade-in-up">
                <div class="inline-flex items-center mb-4 px-4 py-2 rounded-full bg-primary-100 dark:bg-primary-900/30 border border-primary-200 dark:border-primary-800">
                    <svg class="w-4 h-4 mr-2 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-sm font-semibold text-primary-700 dark:text-primary-300">Produk Unggulan</span>
                </div>
                <h2 class="heading-secondary text-neutral-900 dark:text-neutral-100 mb-6">
                    Produk Terpopuler Kami
                </h2>
                <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-400 max-w-3xl mx-auto leading-relaxed">
                    Temukan produk herbal dan makanan olahan terpopuler kami dengan kualitas terbaik dan sertifikasi resmi
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($featuredProducts as $index => $product)
                    <div class="animate-fade-in-up" style="animation-delay: {{ $index * 0.1 }}s">
                        <x-card-product :product="$product" />
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('products.index') }}" class="group inline-flex items-center btn btn-primary">
                    <span>Lihat Semua Produk</span>
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Latest Articles Section - Modern Design -->
    @if(isset($latestArticles) && $latestArticles->count() > 0)
    <section class="section bg-gradient-to-br from-neutral-50 via-white to-neutral-50 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%2310b981\" fill-opacity=\"0.1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="container-custom relative z-10 max-w-7xl">
            <div class="text-center mb-16 animate-fade-in-up">
                <div class="inline-flex items-center mb-4 px-4 py-2 rounded-full bg-primary-100 dark:bg-primary-900/30 border border-primary-200 dark:border-primary-800">
                    <svg class="w-4 h-4 mr-2 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-primary-700 dark:text-primary-300">Artikel Terbaru</span>
                </div>
                <h2 class="heading-secondary text-neutral-900 dark:text-neutral-100 mb-6">
                    Insight & Berita Terbaru
                </h2>
                <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-400 max-w-3xl mx-auto leading-relaxed">
                    Tetap terinformasi dengan berita dan insight terbaru kami tentang produk herbal, kesehatan, dan tips hidup sehat
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($latestArticles as $index => $article)
                    <div class="animate-fade-in-up" style="animation-delay: {{ $index * 0.1 }}s">
                        <x-card-article :article="$article" />
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('articles.index') }}" class="group inline-flex items-center btn btn-outline border-2 border-primary-600 text-primary-700 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20">
                    <span>Lihat Semua Artikel</span>
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section - Modern Design -->
    <section class="section bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 text-white relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Gradient Orbs -->
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            
            <!-- Grid Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
            </div>
        </div>
        
        <div class="container-custom relative z-10 text-center max-w-5xl">
            <div class="animate-fade-in-up">
                <div class="inline-flex items-center mb-6 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md text-white border border-white/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-semibold">Hubungi Kami</span>
                </div>
                <h2 class="heading-secondary text-white mb-6 text-shadow-lg">
                    Siap Merasakan Kualitas?
                </h2>
                <p class="text-xl md:text-2xl text-white/95 mb-10 max-w-3xl mx-auto leading-relaxed">
                    Hubungi kami hari ini untuk mempelajari lebih lanjut tentang produk dan layanan kami. Tim kami siap membantu Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('contact') }}" 
                       class="group relative inline-flex items-center justify-center px-8 py-4 md:px-10 md:py-5 rounded-2xl bg-white text-primary-700 font-bold text-base md:text-lg shadow-2xl hover:shadow-primary-500/30 transform hover:-translate-y-2 hover:scale-105 active:scale-100 transition-all duration-300 overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            <span>Hubungi Kami</span>
                            <svg class="w-5 h-5 md:w-6 md:h-6 ml-3 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="group inline-flex items-center justify-center px-8 py-4 md:px-10 md:py-5 rounded-2xl border-2 border-white text-white font-bold text-base md:text-lg backdrop-blur-md bg-white/10 hover:bg-white hover:text-primary-700 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 hover:scale-105 active:scale-100 transition-all duration-300">
                        <span class="relative z-10">Lihat Produk</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
