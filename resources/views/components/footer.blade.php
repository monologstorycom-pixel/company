<footer class="relative bg-gradient-to-br from-primary-800 via-primary-900 to-primary-950 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 50px 50px;"></div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-700/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-600/20 rounded-full blur-3xl"></div>
    
    <div class="container-custom relative z-10 section-sm max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
            <!-- Company Info -->
            <div class="col-span-1 md:col-span-2 lg:col-span-1">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-2xl blur-lg"></div>
                        <div class="relative w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md border border-white/30 shadow-xl">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-heading font-bold text-white">PT Lestari Jaya Bangsa</h3>
                        <p class="text-xs text-primary-200 mt-0.5">Food & Herbal</p>
                    </div>
                </div>
                <p class="text-primary-100 mb-4 leading-relaxed text-sm">
                    Kesehatan dan Rasa, Dalam Satu Pilihan.
                </p>
                <p class="text-primary-200 text-sm leading-relaxed mb-6">
                    Menyediakan produk herbal dan makanan olahan berkualitas tinggi, berkomitmen memprioritaskan kesehatan dan rasa.
                </p>
                <div class="inline-flex items-center space-x-3 px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 shadow-lg">
                    <svg class="w-5 h-5 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <span class="text-xs font-semibold text-primary-200 block">Berdiri Sejak</span>
                        <span class="text-2xl font-bold text-white">1992</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-heading font-bold mb-6 text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Navigasi Cepat
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="group inline-flex items-center text-primary-200 hover:text-white transition-all duration-300 hover:translate-x-1">
                            <svg class="w-4 h-4 mr-3 transform group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="font-medium">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="group inline-flex items-center text-primary-200 hover:text-white transition-all duration-300 hover:translate-x-1">
                            <svg class="w-4 h-4 mr-3 transform group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="font-medium">Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="group inline-flex items-center text-primary-200 hover:text-white transition-all duration-300 hover:translate-x-1">
                            <svg class="w-4 h-4 mr-3 transform group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="font-medium">Tentang Kami</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('articles.index') }}" class="group inline-flex items-center text-primary-200 hover:text-white transition-all duration-300 hover:translate-x-1">
                            <svg class="w-4 h-4 mr-3 transform group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="font-medium">Artikel</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="group inline-flex items-center text-primary-200 hover:text-white transition-all duration-300 hover:translate-x-1">
                            <svg class="w-4 h-4 mr-3 transform group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="font-medium">Kontak</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-heading font-bold mb-6 text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Informasi Kontak
                </h4>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3 group">
                        <div class="mt-0.5 p-2 rounded-lg bg-white/10 backdrop-blur-sm border border-white/20 group-hover:bg-white/20 transition-colors duration-300">
                            <svg class="w-4 h-4 text-primary-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="text-primary-200 text-sm leading-relaxed flex-1">
                            <p class="group-hover:text-white transition-colors duration-300">Jl. Raya Buntu - Sampang, Utara Pasar, Kali Minyak, Bangsa, Kec. Kebasen, Kabupaten Banyumas, Jawa Tengah 53282</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 group">
                        <div class="p-2 rounded-lg bg-white/10 backdrop-blur-sm border border-white/20 group-hover:bg-white/20 transition-colors duration-300">
                            <svg class="w-4 h-4 text-primary-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <a href="tel:+628219698146" class="text-primary-200 hover:text-white transition-colors duration-300 text-sm font-medium group-hover:translate-x-1 transform transition-transform">
                            (+62) 821-9698-146
                        </a>
                    </div>
                    <div class="flex items-center space-x-3 group">
                        <div class="p-2 rounded-lg bg-white/10 backdrop-blur-sm border border-white/20 group-hover:bg-white/20 transition-colors duration-300">
                            <svg class="w-4 h-4 text-primary-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-primary-200 text-sm">
                            <p class="group-hover:text-white transition-colors duration-300">Jam Operasional:</p>
                            <p class="font-bold text-white text-base">07:00 - 16:00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certifications -->
            <div>
                <h4 class="text-lg font-heading font-bold mb-6 text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Sertifikasi
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 bg-white/10 rounded-xl p-4 backdrop-blur-md border border-white/20 hover:bg-white/20 transition-all duration-300 group cursor-pointer">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-2xl transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            🕌
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Halal MUI</p>
                            <p class="text-xs text-primary-200">Bersertifikat</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/10 rounded-xl p-4 backdrop-blur-md border border-white/20 hover:bg-white/20 transition-all duration-300 group cursor-pointer">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-2xl transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            🏥
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">BPOM</p>
                            <p class="text-xs text-primary-200">Terdaftar & Disetujui</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-primary-700/50 mt-12 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-primary-200 text-sm text-center md:text-left font-medium">
                    &copy; {{ date('Y') }} PT Lestari Jaya Bangsa. All rights reserved.
                </p>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('privacy-policy') }}" class="text-primary-200 hover:text-white transition-colors duration-300 text-sm font-medium hover:underline">
                        Kebijakan Privasi
                    </a>
                    <span class="text-primary-700">|</span>
                    <a href="{{ route('terms-conditions') }}" class="text-primary-200 hover:text-white transition-colors duration-300 text-sm font-medium hover:underline">
                        Syarat & Ketentuan
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

