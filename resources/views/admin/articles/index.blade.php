<x-admin-layout>
    <x-slot name="title">Articles Management</x-slot>

    <!-- Enhanced Header with Stats -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Articles</h1>
            <p class="text-gray-600 mt-1">Manage your content and articles</p>
        </div>
        @can('create articles')
            <a href="{{ route('admin.articles.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
                Add Article
            </a>
        @endcan
    </div>

    <!-- Enhanced Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-white to-emerald-50 p-4 rounded-xl shadow-lg border border-emerald-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Articles</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ $articles->total() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-emerald-100 rounded-xl">
                    <i data-lucide="file-text" class="w-6 h-6 text-emerald-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-green-50 p-4 rounded-xl shadow-lg border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Published</p>
                    <p class="text-2xl font-bold text-green-600">{{ $articles->where('is_published', true)->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-xl">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-blue-50 p-4 rounded-xl shadow-lg border border-blue-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Drafts</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $articles->where('is_published', false)->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-xl">
                    <i data-lucide="edit" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-purple-50 p-4 rounded-xl shadow-lg border border-purple-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Views</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($articles->sum('view_count') ?? 0) }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-xl">
                    <i data-lucide="eye" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Filter Section -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <div class="flex items-center mb-4">
            <i data-lucide="filter" class="w-5 h-5 text-gray-600 mr-2"></i>
            <h3 class="text-lg font-semibold text-gray-900">Filters</h3>
        </div>
        <form method="GET" action="{{ route('admin.articles.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..."
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-3 text-gray-400"></i>
            </div>

            <div class="relative">
                <select name="status" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none transition-all duration-200">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                <i data-lucide="file-text" class="w-4 h-4 absolute left-3 top-3 text-gray-400 pointer-events-none"></i>
            </div>

            <div class="relative">
                <select name="category" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none transition-all duration-200">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <i data-lucide="folder" class="w-4 h-4 absolute left-3 top-3 text-gray-400 pointer-events-none"></i>
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200 font-medium">
                    <i data-lucide="search" class="w-4 h-4 inline mr-2"></i>
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'category']))
                    <a href="{{ route('admin.articles.index') }}" class="px-4 py-2.5 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition-colors font-medium">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 flex items-center animate-pulse-once">
            <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-green-600"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Modern Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Article Library</h3>
                <div class="text-sm text-gray-600">
                    <span class="font-medium">{{ $articles->total() ?? 0 }}</span> total articles
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" class="rounded-xl border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-50 transition-colors">
                            Article <i data-lucide="arrow-up-down" class="w-3 h-3 inline ml-1"></i>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-50 transition-colors">
                            Category <i data-lucide="arrow-up-down" class="w-3 h-3 inline ml-1"></i>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Author
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-50 transition-colors">
                            Views <i data-lucide="arrow-up-down" class="w-3 h-3 inline ml-1"></i>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Published
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($articles as $article)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="rounded-xl border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    @if($article->featured_image)
                                        <img class="h-12 w-12 rounded-xl object-cover shadow-sm border-2 border-gray-200" src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}">
                                    @else
                                        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center border-2 border-gray-200">
                                            <i data-lucide="file-text" class="w-5 h-5 text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-semibold text-gray-900 truncate">{{ $article->title }}</div>
                                    <div class="text-sm text-gray-500 truncate">{{ \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?? $article->content ?? ''), 80) }}</div>
                                    <div class="flex items-center mt-1 space-x-2">
                                        @if($article->featured)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i data-lucide="star" class="w-3 h-3 mr-1"></i>
                                                Featured
                                            </span>
                                        @endif
                                        <span class="text-xs text-gray-400">
                                            <i data-lucide="calendar" class="w-3 h-3 inline mr-1"></i>
                                            {{ $article->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $article->category->name ?? 'No Category' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-sm text-gray-900">
                                <div class="w-6 h-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-xs font-medium text-white">{{ substr($article->author->name ?? 'A', 0, 1) }}</span>
                                </div>
                                {{ $article->author->name ?? 'Unknown' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                {{ ($article->is_published ?? false) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full mr-2 {{ ($article->is_published ?? false) ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                {{ ($article->is_published ?? false) ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-sm font-medium text-gray-900">
                                <i data-lucide="eye" class="w-4 h-4 mr-1 text-gray-400"></i>
                                {{ number_format($article->view_count ?? 0) }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $article->published_at?->format('M d, Y') ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-1">
                                <a href="{{ route('admin.articles.show', $article) }}"
                                   class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="View">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                @can('edit articles')
                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                       class="p-2 text-emerald-600 hover:text-emerald-800 hover:bg-emerald-50 rounded-lg transition-colors"
                                       title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                @endcan
                                @can('delete articles')
                                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="file-x" class="w-16 h-16 text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium mb-2">No articles found</p>
                                <p class="text-gray-400 text-sm mb-4">Start creating content to engage your audience</p>
                                @can('create articles')
                                    <a href="{{ route('admin.articles.create') }}"
                                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-lg hover:from-emerald-700 hover:to-emerald-800 transition-all">
                                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                        Create Article
                                    </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Enhanced Pagination -->
        @if($articles->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div class="text-sm text-gray-600">
                Showing <span class="font-medium">{{ $articles->firstItem() }}</span> to
                <span class="font-medium">{{ $articles->lastItem() }}</span> of
                <span class="font-medium">{{ $articles->total() }}</span> results
            </div>
            <div class="flex items-center space-x-2">
                {{ $articles->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- Bulk Actions (Hidden by default) -->
    <div id="bulkActions" class="hidden fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-white rounded-xl shadow-2xl border border-gray-200 p-4 z-50">
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">
                <span id="selectedCount">0</span> articles selected
            </span>
            <button class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm">
                <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                View Selected
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                Edit Selected
            </button>
            <button onclick="clearSelection()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors text-sm">
                Cancel
            </button>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Select all functionality
        const selectAllCheckbox = document.querySelector('thead input[type="checkbox"]');
        const rowCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActions();
            });
        }

        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const selectedCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
            if (selectedCheckboxes.length > 0) {
                bulkActions.classList.remove('hidden');
                selectedCount.textContent = selectedCheckboxes.length;
            } else {
                bulkActions.classList.add('hidden');
            }
        }

        function clearSelection() {
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            updateBulkActions();
        }

        // Re-initialize icons periodically
        setInterval(() => lucide.createIcons(), 1000);
    </script>
</x-admin-layout>

