<x-frontend-layout>
    <x-slot name="title">{{ $product->name }} - Produk | PT Lestari Jaya Bangsa</x-slot>
    <x-slot name="metaDescription">{{ \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160) }}</x-slot>

    <!-- Breadcrumb -->
    <section class="bg-neutral-50 dark:bg-neutral-900 py-4">
        <div class="container-custom">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-neutral-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            Produk
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-neutral-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="text-neutral-900 dark:text-neutral-100 font-medium" aria-current="page">
                        {{ $product->name }}
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Product Detail -->
    <section class="section bg-white dark:bg-neutral-50">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div>
                    <div class="relative bg-neutral-100 dark:bg-neutral-800 rounded-2xl overflow-hidden mb-4 aspect-square" id="main-image-container">
                        @if($product->getFirstMediaUrl('images'))
                            <img id="main-product-image" 
                                 src="{{ $product->getFirstMediaUrl('images') }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover"
                                 loading="eager">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-24 h-24 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Gallery -->
                    @php
                        $allImages = $product->getMedia('images');
                    @endphp
                    @if($allImages->count() > 1)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($allImages as $index => $media)
                                <button type="button" 
                                        onclick="changeMainImage('{{ $media->getUrl() }}', this)"
                                        class="focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-lg overflow-hidden transition-all">
                                    <img src="{{ $media->getUrl('thumb') }}" 
                                         alt="{{ $product->name }} - Gambar {{ $index + 1 }}" 
                                         class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-80 border-2 transition-all {{ $index === 0 ? 'border-primary-500' : 'border-transparent hover:border-primary-300' }}"
                                         loading="lazy">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    <h1 class="heading-secondary text-neutral-900 dark:text-neutral-100 mb-4">
                        {{ $product->name }}
                    </h1>

                    <!-- Certifications -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        @if($product->is_halal ?? false)
                            <span class="badge badge-success">
                                🕌 Halal MUI
                            </span>
                        @endif
                        @if($product->bpom_number ?? false)
                            <span class="badge badge-primary">
                                🏥 BPOM
                            </span>
                        @endif
                    </div>

                    <!-- Price -->
                    @if($product->price ?? false)
                        <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-6">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    @else
                        <div class="text-lg text-neutral-600 dark:text-neutral-400 mb-6">
                            <a href="{{ route('contact') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 underline">
                                Hubungi kami untuk harga
                            </a>
                        </div>
                    @endif

                    <!-- Category -->
                    @if($product->category)
                        <div class="mb-6">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">Kategori:</span>
                            <span class="text-sm font-medium text-neutral-900 dark:text-neutral-100 ml-2">
                                {{ $product->category->name }}
                            </span>
                        </div>
                    @endif

                    <!-- Description -->
                    @if($product->description)
                        <div class="prose prose-lg max-w-none mb-8">
                            <h3 class="text-lg font-heading font-semibold text-neutral-900 dark:text-neutral-100 mb-3">
                                Deskripsi Produk
                            </h3>
                            <div class="text-body">
                                {!! $product->description !!}
                            </div>
                        </div>
                    @endif

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        <a href="{{ route('contact') }}" class="btn btn-primary flex-1 text-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Hubungi Kami
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline flex-1 text-center">
                            Kembali ke Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <section class="section bg-neutral-50 dark:bg-neutral-900">
        <div class="container-custom">
            <h2 class="heading-secondary text-neutral-900 dark:text-neutral-100 mb-8">
                Produk Serupa
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <x-card-product :product="$relatedProduct" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <script>
        function changeMainImage(imageUrl, thumbElement) {
            const mainImage = document.getElementById('main-product-image');
            if (mainImage) {
                mainImage.src = imageUrl;
            }
            // Update border on thumbnails
            if (thumbElement) {
                document.querySelectorAll('#main-image-container ~ .grid button img').forEach(img => {
                    img.classList.remove('border-primary-500');
                    img.classList.add('border-transparent');
                });
                const thumbImg = thumbElement.querySelector('img');
                if (thumbImg) {
                    thumbImg.classList.remove('border-transparent');
                    thumbImg.classList.add('border-primary-500');
                }
            }
        }
    </script>
</x-frontend-layout>
