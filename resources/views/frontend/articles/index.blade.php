<x-frontend-layout>
    <x-slot name="title">Artikel & Berita - PT Lestari Jaya Bangsa</x-slot>
    <x-slot name="metaDescription">Tetap terinformasi dengan berita terbaru, insight, dan artikel tentang produk herbal, kesehatan, dan kesejahteraan alami dari PT Lestari Jaya Bangsa.</x-slot>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-16 md:py-20">
        <div class="container-custom text-center">
            <h1 class="heading-primary text-white mb-4">Artikel & Berita</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Tetap terinformasi dengan insight, berita, dan konten edukasi terbaru kami
                tentang produk herbal, kesehatan, dan kesejahteraan alami.
            </p>
        </div>
    </section>

    <!-- Filters and Search -->
    <section class="section-sm bg-neutral-50 dark:bg-neutral-900">
        <div class="container-custom">
            <form method="GET" action="{{ route('articles.index') }}" class="card p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label for="search" class="sr-only">Cari artikel</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" 
                                   id="search"
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari artikel..."
                                   class="w-full pl-10 pr-4 py-2.5 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-800 dark:text-neutral-100">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="sr-only">Kategori</label>
                        <select name="category" 
                                id="category"
                                class="w-full px-4 py-2.5 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="">Semua Kategori</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                    <button type="submit" class="btn btn-primary flex-1 sm:flex-none">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('articles.index') }}" class="btn btn-outline flex-1 sm:flex-none">
                            Hapus Filter
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="section bg-white dark:bg-neutral-50">
        <div class="container-custom">
            @if(isset($articles) && $articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($articles as $index => $article)
                        <div class="animate-fade-in-up" style="animation-delay: {{ min($index * 0.1, 0.5) }}s">
                            <x-card-article :article="$article" />
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if(method_exists($articles, 'links'))
                    <div class="flex justify-center">
                        {{ $articles->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-neutral-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-heading font-semibold text-neutral-900 dark:text-neutral-100 mb-3">
                        Artikel Tidak Ditemukan
                    </h3>
                    <p class="text-body mb-8 max-w-md mx-auto">
                        Coba sesuaikan kriteria pencarian Anda atau kembali lagi nanti untuk konten baru.
                    </p>
                    <a href="{{ route('articles.index') }}" class="btn btn-primary">
                        Lihat Semua Artikel
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-frontend-layout>
