<x-frontend-layout>
    <x-slot name="title">Syarat & Ketentuan - PT Lestari Jaya Bangsa</x-slot>
    <x-slot name="metaDescription">Syarat dan ketentuan penggunaan layanan PT Lestari Jaya Bangsa. Harap baca dengan seksama sebelum menggunakan layanan kami.</x-slot>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-16 md:py-20">
        <div class="container-custom text-center">
            <h1 class="heading-primary text-white mb-4">Syarat & Ketentuan</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Terakhir diperbarui: {{ date('d F Y') }}
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="section bg-white dark:bg-neutral-50">
        <div class="container-custom max-w-4xl">
            <div class="prose prose-lg max-w-none">
                
                <!-- Introduction -->
                <div class="card-premium p-8 mb-8">
                    <h2 class="text-2xl font-heading font-bold text-neutral-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Ketentuan Umum
                    </h2>
                    <div class="space-y-4 text-neutral-600">
                        <p>
                            Selamat datang di PT Lestari Jaya Bangsa. Dengan mengakses atau menggunakan layanan kami, Anda menyetujui untuk terikat oleh syarat dan ketentuan ini. Jika Anda tidak setuju dengan syarat ini, mohon untuk tidak menggunakan layanan kami.
                        </p>
                        <p>
                            Syarat dan ketentuan ini berlaku untuk semua pengunjung, pengguna, dan pihak lain yang mengakses atau menggunakan layanan kami.
                        </p>
                    </div>
                </div>

                <!-- Products and Services -->
                <div class="card-premium p-8 mb-8">
                    <h2 class="text-2xl font-heading font-bold text-neutral-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Produk dan Layanan
                    </h2>
                    <div class="space-y-4 text-neutral-600">
                        <p>PT Lestari Jaya Bangsa menyediakan produk herbal dan makanan olahan berkualitas. Mengenai produk kami:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Semua produk telah bersertifikat Halal MUI dan terdaftar di BPOM</li>
                            <li>Informasi produk yang ditampilkan bertujuan untuk memberikan gambaran umum</li>
                            <li>Harga produk dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya</li>
                            <li>Ketersediaan produk tergantung pada stok yang ada</li>
                            <li>Gambar produk mungkin sedikit berbeda dari produk asli</li>
                        </ul>
                    </div>
                </div>

                <!-- Ordering -->
                <div class="card-premium p-8 mb-8">
                    <h2 class="text-2xl font-heading font-bold text-neutral-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Pemesanan dan Pembayaran
                    </h2>
                    <div class="space-y-4 text-neutral-600">
                        <p>Ketentuan pemesanan:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Pemesanan dapat dilakukan melalui WhatsApp, telepon, atau formulir kontak</li>
                            <li>Pesanan dianggap sah setelah konfirmasi dari pihak kami</li>
                            <li>Pembayaran harus dilakukan sesuai dengan instruksi yang diberikan</li>
                            <li>Kami berhak membatalkan pesanan jika terjadi kesalahan harga atau informasi</li>
                            <li>Pesanan akan diproses setelah pembayaran dikonfirmasi</li>
                        </ul>
                    </div>
                </div>

                <!-- Shipping -->
                <div class="card-premium p-8 mb-8">
                    <h2 class="text-2xl font-heading font-bold text-neutral-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Pengiriman
                    </h2>
                    <div class="space-y-4 text-neutral-600">
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Pengiriman dilakukan ke seluruh Indonesia</li>
                            <li>Biaya pengiriman ditanggung oleh pembeli kecuali ada ketentuan lain</li>
                            <li>Waktu pengiriman tergantung pada lokasi tujuan dan jasa ekspedisi</li>
                            <li>Kami tidak bertanggung jawab atas keterlambatan yang disebabkan oleh pihak ekspedisi</li>
                            <li>Pastikan alamat pengiriman yang diberikan sudah benar dan lengkap</li>
                        </ul>
                    </div>
                </div>

                <!-- Returns -->
                <div class="card-premium p-8 mb-8">
                    <h2 class="text-2xl font-heading font-bold text-neutral-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Pengembalian dan Penukaran
                    </h2>
                    <div class="space-y-4 text-neutral-600">
                        <p>Kebijakan pengembalian:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Pengembalian diterima jika produk rusak atau tidak sesuai pesanan</li>
                            <li>Klaim harus dilakukan dalam waktu 3x24 jam setelah produk diterima</li>
                            <li>Produk yang dikembalikan harus dalam kondisi asli dan kemasan lengkap</li>
                            <li>Biaya pengembalian ditanggung oleh pembeli kecuali kesalahan dari pihak kami</li>
                            <li>Pengembalian dana akan diproses dalam 7-14 hari kerja</li>
                        </ul>
                    </div>
                </div>

                <!-- Intellectual Property -->
                <div class="card-premium p-8 mb-8">
                    <h2 class="text-2xl font-heading font-bold text-neutral-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Hak Kekayaan Intelektual
                    </h2>
                    <div class="space-y-4 text-neutral-600">
                        <p>Semua konten di website ini termasuk namun tidak terbatas pada:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Teks, grafik, logo, gambar, dan desain</li>
                            <li>Nama merek dan merek dagang</li>
                            <li>Konten artikel dan materi informatif</li>
                        </ul>
                        <p class="mt-4">adalah milik PT Lestari Jaya Bangsa dan dilindungi oleh hukum hak cipta Indonesia. Penggunaan tanpa izin tertulis adalah pelanggaran hukum.</p>
                    </div>
                </div>

                <!-- Limitation of Liability -->
                <div class="card-premium p-8 mb-8">
                    <h2 class="text-2xl font-heading font-bold text-neutral-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Batasan Tanggung Jawab
                    </h2>
                    <div class="space-y-4 text-neutral-600">
                        <p>PT Lestari Jaya Bangsa tidak bertanggung jawab atas:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Kerugian tidak langsung yang timbul dari penggunaan layanan kami</li>
                            <li>Gangguan atau kesalahan teknis di luar kendali kami</li>
                            <li>Tindakan pihak ketiga termasuk jasa ekspedisi</li>
                            <li>Penggunaan produk yang tidak sesuai dengan petunjuk</li>
                        </ul>
                    </div>
                </div>

                <!-- Changes -->
                <div class="card-premium p-8 mb-8">
                    <h2 class="text-2xl font-heading font-bold text-neutral-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Perubahan Syarat & Ketentuan
                    </h2>
                    <div class="space-y-4 text-neutral-600">
                        <p>
                            Kami berhak untuk mengubah atau memperbarui syarat dan ketentuan ini kapan saja. Perubahan akan berlaku segera setelah dipublikasikan di website ini. Penggunaan layanan secara berkelanjutan setelah perubahan dianggap sebagai penerimaan terhadap syarat yang diperbarui.
                        </p>
                    </div>
                </div>

                <!-- Contact -->
                <div class="card-premium p-8 bg-gradient-to-br from-primary-50 to-white">
                    <h2 class="text-2xl font-heading font-bold text-neutral-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Hubungi Kami
                    </h2>
                    <p class="text-neutral-600 mb-4">
                        Jika Anda memiliki pertanyaan tentang Syarat & Ketentuan ini, silakan hubungi kami:
                    </p>
                    <div class="bg-white rounded-xl p-4 border border-primary-100">
                        <p class="font-semibold text-neutral-900">PT Lestari Jaya Bangsa</p>
                        <p class="text-neutral-600">Jl. Raya Buntu - Sampang, Utara Pasar, Kali Minyak</p>
                        <p class="text-neutral-600">Kec. Kebasen, Kab. Banyumas, Jawa Tengah 53282</p>
                        <p class="text-neutral-600 mt-2">📞 (+62) 821-9698-146</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-frontend-layout>
