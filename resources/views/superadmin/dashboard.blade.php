<x-admin-layout>
    <x-slot name="title">Super Admin Dashboard</x-slot>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Users</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                    <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Products</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['total_products'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['active_products'] ?? 0 }} active</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Articles</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['total_articles'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['published_articles'] ?? 0 }} published</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">New Contacts</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['unread_contacts'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['total_contacts'] ?? 0 }} total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Today's Chats</h3>
            <p class="text-2xl font-bold text-indigo-600">{{ $stats['today_chats'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Total Chat Sessions</h3>
            <p class="text-2xl font-bold text-indigo-600">{{ $stats['total_chats'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">System Status</h3>
            <p class="text-2xl font-bold text-green-600">Healthy</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Users</h3>
            </div>
            <div class="p-6">
                @if($recentUsers->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentUsers as $user)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $user->getRoleNames()->first() ?? 'No Role' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No users yet</p>
                @endif
            </div>
        </div>

        <!-- Recent Contacts -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Contacts</h3>
            </div>
            <div class="p-6">
                @if($recentContacts->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentContacts as $contact)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $contact->name }}</p>
                                <p class="text-sm text-gray-600">{{ $contact->subject }}</p>
                                <p class="text-xs text-gray-500">{{ $contact->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $contact->status === 'unread' ? 'bg-yellow-100 text-yellow-800' :
                                   ($contact->status === 'read' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($contact->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.contacts.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                            View all contacts →
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No contacts yet</p>
                @endif
                </div>
            </div>

        <!-- Recent Articles -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Articles</h3>
            </div>
            <div class="p-6">
                @if($recentArticles->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentArticles as $article)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ \Illuminate\Support\Str::limit($article->title, 30) }}</p>
                                <p class="text-sm text-gray-600">By {{ $article->author->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500">{{ $article->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ ($article->is_published ?? false) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ($article->is_published ?? false) ? 'Published' : 'Draft' }}
                            </span>
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
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>