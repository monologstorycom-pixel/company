@props(['product'])

<div class="group relative card-premium overflow-hidden h-full flex flex-col">
    <!-- Product Image -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 aspect-[4/3]">
        @if($product->getFirstMediaUrl('images'))
            <img 
                src="{{ $product->getFirstMediaUrl('images') }}" 
                alt="{{ $product->name }}"
                class="w-full h-full object-cover transition-all duration-700 group-hover:scale-125 group-hover:rotate-2"
                loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20">
                <svg class="w-20 h-20 text-primary-400 dark:text-primary-500 transform group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        @endif
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <!-- Badges -->
        <div class="absolute top-4 left-4 flex flex-wrap gap-2 z-10">
            @if($product->is_halal_certified)
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-white/95 dark:bg-neutral-800/95 backdrop-blur-md text-primary-700 dark:text-primary-400 shadow-lg border border-primary-200 dark:border-primary-700">
                    <span class="mr-1.5">🕌</span>
                    Halal
                </span>
            @endif
            @if($product->is_bpom_certified)
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-white/95 dark:bg-neutral-800/95 backdrop-blur-md text-primary-700 dark:text-primary-400 shadow-lg border border-primary-200 dark:border-primary-700">
                    <span class="mr-1.5">🏥</span>
                    BPOM
                </span>
            @endif
        </div>
        
        <!-- Hover Action Button -->
        <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 z-10">
            <a href="{{ route('products.show', $product->slug) }}" 
               class="block w-full bg-white dark:bg-neutral-800 text-primary-700 dark:text-primary-400 text-center py-3 px-4 rounded-xl font-semibold shadow-xl hover:bg-primary-50 dark:hover:bg-neutral-700 transition-colors duration-300">
                Lihat Detail
            </a>
        </div>
    </div>
    
    <!-- Product Info -->
    <div class="p-6 flex-grow flex flex-col">
        @if($product->category)
            <div class="mb-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 border border-primary-200 dark:border-primary-800">
                    {{ $product->category->name }}
                </span>
            </div>
        @endif
        
        <h3 class="text-xl font-heading font-bold text-neutral-900 dark:text-neutral-100 mb-3 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:underline">
                {{ $product->name }}
            </a>
        </h3>
        
        @if($product->description)
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-6 line-clamp-2 leading-relaxed flex-grow">
                {{ \Illuminate\Support\Str::limit(strip_tags($product->description), 100) }}
            </p>
        @endif
        
        <div class="mt-auto pt-4 border-t border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                @if($product->price)
                    <div>
                        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                @else
                    <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                        Hubungi untuk harga
                    </span>
                @endif
                
                <a href="{{ route('products.show', $product->slug) }}" 
                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 group/btn">
                    <svg class="w-5 h-5 transform group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

