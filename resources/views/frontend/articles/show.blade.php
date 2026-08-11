<x-frontend-layout>
    <x-slot name="title">{{ $article->title }} - Artikel | PT Lestari Jaya Bangsa</x-slot>
    <x-slot name="metaDescription">{{ $article->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($article->content), 160) }}</x-slot>

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
                        <a href="{{ route('articles.index') }}" class="text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            Artikel
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-neutral-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="text-neutral-900 dark:text-neutral-100 font-medium" aria-current="page">
                        {{ \Illuminate\Support\Str::limit($article->title, 40) }}
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Article Detail -->
    <section class="section bg-white dark:bg-neutral-50">
        <div class="container-custom max-w-4xl">
            <!-- Article Header -->
            <header class="mb-8">
                @if($article->category)
                    <div class="mb-4">
                        <a href="{{ route('articles.index', ['category' => $article->category->id]) }}" 
                           class="badge badge-primary">
                            {{ $article->category->name }}
                        </a>
                    </div>
                @endif

                <h1 class="heading-secondary text-neutral-900 dark:text-neutral-100 mb-4">
                    {{ $article->title }}
                </h1>

                @if($article->excerpt)
                    <p class="text-xl text-body mb-6">
                        {{ $article->excerpt }}
                    </p>
                @endif

                <div class="flex flex-wrap items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400 border-b border-neutral-200 dark:border-neutral-700 pb-6">
                    @if($article->author ?? false)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="font-medium text-neutral-900 dark:text-neutral-100">{{ $article->author->name ?? 'Admin' }}</span>
                        </div>
                    @endif
                    
                    @if($article->published_at)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <time datetime="{{ $article->published_at->toISOString() }}">
                                {{ $article->published_at->format('d F Y') }}
                            </time>
                        </div>
                    @endif

                    @if($article->view_count ?? false)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ $article->view_count }} views
                        </div>
                    @endif
                </div>
            </header>

            <!-- Featured Image -->
            @if($article->featured_image)
                <div class="mb-8 rounded-2xl overflow-hidden shadow-xl">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                         alt="{{ $article->title }}" 
                         class="w-full h-auto object-cover"
                         loading="eager">
                </div>
            @endif

            <!-- Article Content -->
            <div class="prose prose-lg prose-gray dark:prose-invert max-w-none mb-12">
                {!! $article->content !!}
            </div>

            <!-- Tags -->
            @if($article->tags && $article->tags->count() > 0)
                <div class="mb-8 pb-8 border-b border-neutral-200 dark:border-neutral-700">
                    <h3 class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-3">Tag:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($article->tags as $tag)
                            <a href="{{ route('articles.index', ['tag' => $tag->name ?? $tag]) }}"
                               class="badge badge-secondary hover:bg-primary-100 dark:hover:bg-primary-900/30 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                                #{{ $tag->name ?? $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Share Buttons -->
            <div class="mb-12">
                <h3 class="text-lg font-heading font-semibold text-neutral-900 dark:text-neutral-100 mb-4">
                    Bagikan Artikel
                </h3>
                <div class="flex flex-wrap gap-3">
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(route('articles.show', $article->slug)) }}"
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn btn-outline flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                        </svg>
                        Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article->slug)) }}"
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn btn-outline flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                        </svg>
                        Facebook
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . route('articles.show', $article->slug)) }}"
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn btn-outline flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"></path>
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>

            <!-- Related Articles -->
            @if(isset($relatedArticles) && $relatedArticles->count() > 0)
            <div class="border-t border-neutral-200 dark:border-neutral-700 pt-12">
                <h2 class="heading-secondary text-neutral-900 dark:text-neutral-100 mb-8">
                    Artikel Terkait
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $relatedArticle)
                        <x-card-article :article="$relatedArticle" />
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Back to Articles -->
            <div class="text-center mt-12">
                <a href="{{ route('articles.index') }}" class="btn btn-outline">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Berita
                </a>
            </div>
        </div>
    </section>
</x-frontend-layout>
