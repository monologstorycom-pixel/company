@props(['article'])

<article class="group relative card-premium overflow-hidden h-full flex flex-col">
    <!-- Article Image -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 aspect-video">
        @if($article->featured_image)
            <img 
                src="{{ asset('storage/' . $article->featured_image) }}" 
                alt="{{ $article->title }}"
                class="w-full h-full object-cover transition-all duration-700 group-hover:scale-125 group-hover:rotate-2"
                loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20">
                <svg class="w-20 h-20 text-primary-400 dark:text-primary-500 transform group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
        @endif
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <!-- Category Badge -->
        @if($article->category)
            <div class="absolute top-4 left-4 z-10">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-white/95 dark:bg-neutral-800/95 backdrop-blur-md text-primary-700 dark:text-primary-400 shadow-lg border border-primary-200 dark:border-primary-700">
                    {{ $article->category->name }}
                </span>
            </div>
        @endif
        
        <!-- Date Badge -->
        @if($article->published_at)
            <div class="absolute top-4 right-4 z-10">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-white/95 dark:bg-neutral-800/95 backdrop-blur-md text-neutral-700 dark:text-neutral-300 shadow-lg border border-neutral-200 dark:border-neutral-700">
                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $article->published_at->format('d M Y') }}
                </span>
            </div>
        @endif
    </div>
    
    <!-- Article Content -->
    <div class="p-6 flex-grow flex flex-col">
        <h3 class="text-xl font-heading font-bold text-neutral-900 dark:text-neutral-100 mb-3 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">
            <a href="{{ route('articles.show', $article->slug) }}" class="hover:underline">
                {{ $article->title }}
            </a>
        </h3>
        
        @if($article->excerpt || $article->content)
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-6 line-clamp-3 flex-grow leading-relaxed">
                {{ $article->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($article->content), 150) }}
            </p>
        @endif
        
        <div class="mt-auto pt-4 border-t border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 text-xs text-neutral-500 dark:text-neutral-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span class="font-medium">{{ $article->view_count ?? 0 }} views</span>
                </div>
                
                <a href="{{ route('articles.show', $article->slug) }}" 
                   class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold text-sm group/link transition-colors duration-300">
                    Baca
                    <svg class="w-4 h-4 ml-1 transform group-hover/link:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</article>

