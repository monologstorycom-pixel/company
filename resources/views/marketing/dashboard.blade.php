<x-admin-layout>
    <x-slot name="title">Marketing Dashboard</x-slot>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">My Articles</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['my_articles'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['published_articles'] ?? 0 }} published, {{ $stats['draft_articles'] ?? 0 }} drafts</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Today's Chats</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['today_chats'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['total_chats'] ?? 0 }} total sessions</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Published</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['published_articles'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">Published articles</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- My Recent Articles -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">My Recent Articles</h3>
            </div>
            <div class="p-6">
                @if($myRecentArticles->count() > 0)
                    <div class="space-y-4">
                        @foreach($myRecentArticles as $article)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ \Illuminate\Support\Str::limit($article->title, 40) }}</p>
                                <p class="text-xs text-gray-500">{{ $article->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex gap-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ ($article->is_published ?? false) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ($article->is_published ?? false) ? 'Published' : 'Draft' }}
                                </span>
                                <a href="{{ route('admin.articles.edit', $article) }}" class="text-green-600 hover:text-green-700 text-sm">
                                    Edit
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.articles.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                            View all articles →
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No articles yet</p>
                    <div class="mt-4">
                        <a href="{{ route('admin.articles.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors inline-block">
                            Create Your First Article
                        </a>
                    </div>
                @endif
                </div>
            </div>

        <!-- Recent Chat Interactions -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Chat Interactions</h3>
            </div>
            <div class="p-6">
                @if($recentChats->count() > 0)
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach($recentChats as $chat)
                        <div class="border-l-4 border-green-500 pl-4 py-2">
                            <p class="text-sm font-medium text-gray-900">User: {{ \Illuminate\Support\Str::limit($chat->user_message, 50) }}</p>
                            <p class="text-sm text-gray-600 mt-1">Bot: {{ \Illuminate\Support\Str::limit($chat->bot_response, 60) }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $chat->created_at->diffForHumans() }}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.chatbot.history') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                            View all chat history →
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No chat interactions yet</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.articles.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                Create New Article
            </a>
            <a href="{{ route('admin.chatbot.history') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                View Chat Analytics
            </a>
            <a href="{{ route('admin.articles.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Manage Articles
            </a>
        </div>
    </div>
</x-admin-layout>