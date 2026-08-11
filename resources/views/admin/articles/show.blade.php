<x-admin-layout>
    <x-slot name="title">View Article</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $article->title }}</h1>
        <div class="flex gap-2">
            @can('edit articles')
            <a href="{{ route('admin.articles.edit', $article) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                Edit Article
            </a>
            @endcan
            <a href="{{ route('admin.articles.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                Back to Articles
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            @if($article->featured_image)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-64 object-cover">
            </div>
            @endif

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <span>{{ $article->category->name ?? 'Uncategorized' }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $article->author->name ?? 'Unknown' }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $article->published_at?->format('M d, Y') ?? 'Not published' }}</span>
                </div>

                @if($article->excerpt)
                <div class="prose prose-lg max-w-none mb-6">
                    <p class="text-xl text-gray-600 font-medium">{{ $article->excerpt }}</p>
                </div>
                @endif

                <div class="prose prose-lg max-w-none">
                    {!! $article->content !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Article Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Article Information</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Category</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $article->category->name ?? 'No Category' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Author</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $article->author->name ?? 'Unknown' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ ($article->is_published ?? false) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ($article->is_published ?? false) ? 'Published' : 'Draft' }}
                            </span>
                            @if($article->featured)
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Featured
                            </span>
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Views</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ number_format($article->view_count ?? 0) }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Published At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $article->published_at?->format('M d, Y H:i') ?? 'Not published' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Slug</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono break-all">{{ $article->slug }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Tags -->
            @if($article->tags && count($article->tags) > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Tags</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        #{{ is_array($tag) ? $tag['name'] : $tag->name ?? $tag }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                <div class="space-y-2">
                    <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        View on Site
                    </a>
                    @can('delete articles')
                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Are you sure you want to delete this article?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            Delete Article
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

