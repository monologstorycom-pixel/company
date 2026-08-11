<x-frontend-layout>
    <x-slot name="title">Kontak - PT Lestari Jaya Bangsa</x-slot>
    <x-slot name="metaDescription">Hubungi PT Lestari Jaya Bangsa. Hubungi kami untuk pertanyaan tentang produk herbal dan makanan kami. Alamat, telepon, dan jam operasional tersedia.</x-slot>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-16 md:py-20">
        <div class="container-custom text-center">
            <h1 class="heading-primary text-white mb-4">Hubungi Kami</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Ada pertanyaan tentang produk atau layanan kami? Kami senang mendengar dari Anda.
                Kirimkan pesan dan kami akan merespons secepat mungkin.
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section bg-white dark:bg-neutral-50">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="card-premium p-8">
                    <h2 class="heading-tertiary text-neutral-900 dark:text-neutral-100 mb-6">
                        Kirim Pesan
                    </h2>

                    @if(session('success'))
                        <div class="bg-success-100 border border-success-400 text-success-700 px-4 py-3 rounded-lg mb-6 animate-fade-in">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-error-100 border border-error-400 text-error-700 px-4 py-3 rounded-lg mb-6">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6" x-data="{ submitting: false }" @submit="submitting = true">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Nama Lengkap <span class="text-error-600">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-800 dark:text-neutral-100 transition-all"
                                   required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Alamat Email <span class="text-error-600">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-800 dark:text-neutral-100 transition-all"
                                   required>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Nomor Telepon
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-800 dark:text-neutral-100 transition-all">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Subjek <span class="text-error-600">*</span>
                            </label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}"
                                   class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-800 dark:text-neutral-100 transition-all"
                                   required>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Pesan <span class="text-error-600">*</span>
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="6"
                                      class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-800 dark:text-neutral-100 transition-all resize-none"
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" 
                                :disabled="submitting"
                                class="w-full btn btn-primary"
                                :class="{ 'opacity-50 cursor-not-allowed': submitting }">
                            <span x-show="!submitting">Kirim Pesan</span>
                            <span x-show="submitting" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Mengirim...
                            </span>
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-6">
                    <!-- Contact Details -->
                    <div class="card-premium p-8">
                        <h2 class="heading-tertiary text-neutral-900 dark:text-neutral-100 mb-6">
                            Informasi Kontak
                        </h2>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-neutral-900 dark:text-neutral-100 mb-1">Alamat</h3>
                                    <p class="text-body">
                                        Jl. Raya Buntu - Sampang, Utara Pasar,<br>
                                        Kali Minyak, Bangsa, Kec. Kebasen,<br>
                                        Kabupaten Banyumas, Jawa Tengah 53282
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-neutral-900 dark:text-neutral-100 mb-1">Telepon</h3>
                                    <a href="tel:+628219698146" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                                        (+62) 821-9698-146
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-neutral-900 dark:text-neutral-100 mb-1">Jam Operasional</h3>
                                    <p class="text-body font-semibold">07:00 - 16:00 WIB</p>
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Senin - Sabtu</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="card-premium p-8">
                        <h3 class="text-xl font-heading font-semibold text-neutral-900 dark:text-neutral-100 mb-4">
                            Lokasi Kami
                        </h3>
                        <div class="rounded-lg overflow-hidden shadow-lg" style="height: 400px;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.2573485821876!2d109.19545871477359!3d-7.414239194660824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e65601c8c7e9a05%3A0x7d5e5e5e5e5e5e5e!2sJl.%20Raya%20Buntu%20-%20Sampang%2C%20Utara%20Pasar%2C%20Kali%20Minyak%2C%20Bangsa%2C%20Kec.%20Kebasen%2C%20Kabupaten%20Banyumas%2C%20Jawa%20Tengah%2053282!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid"
                                width="100%"
                                height="100%"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                class="w-full h-full">
                            </iframe>
                        </div>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-4 text-center">
                            <a href="https://maps.google.com/?q=Jl.+Raya+Buntu+-+Sampang,+Utara+Pasar,+Kali+Minyak,+Bangsa,+Kec.+Kebasen,+Kabupaten+Banyumas,+Jawa+Tengah+53282" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium transition-colors">
                                Buka di Google Maps →
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
