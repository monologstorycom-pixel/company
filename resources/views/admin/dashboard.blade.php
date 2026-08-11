<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <!-- Modern Dashboard Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 rounded-2xl shadow-xl overflow-hidden">
            <div class="relative px-8 py-10 sm:px-10 sm:py-12">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
                </div>

                <!-- Header Content -->
                <div class="relative">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">
                                Dashboard Overview
                            </h1>
                            <p class="text-lg text-blue-100 max-w-2xl">
                                Welcome back! Here's what's happening with your business today.
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-6">
                            <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg px-4 py-2">
                                <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm text-blue-100">{{ now()->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-6 mb-8">
        @can('view products')
        <div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-xl group-hover:bg-blue-100 transition-colors">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">+12%</span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Products</p>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['total_products'] ?? 0 }}</p>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $stats['active_products'] ?? 0 }} Active
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('view articles')
        <div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="p-3 bg-emerald-50 rounded-xl group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">+8%</span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Articles</p>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['total_articles'] ?? 0 }}</p>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $stats['published_articles'] ?? 0 }} Published
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('view contacts')
        <div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-purple-600 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="p-3 bg-purple-50 rounded-xl group-hover:bg-purple-100 transition-colors">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full">{{ $stats['unread_contacts'] ?? 0 }} New</span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Contacts</p>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['total_contacts'] ?? 0 }}</p>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center text-xs text-gray-500">
                        @if(($stats['unread_contacts'] ?? 0) > 0)
                            <svg class="w-4 h-4 mr-1 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $stats['unread_contacts'] }} Unread
                        @else
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            All read
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('view chatbot')
        <div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 to-orange-600 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="p-3 bg-orange-50 rounded-xl group-hover:bg-orange-100 transition-colors">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full">Today</span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Chat Activity</p>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['today_chats'] ?? 0 }}</p>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        Active today
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>

    <!-- Modern Charts Section -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
        <!-- Featured Products Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Featured Products</h3>
                    <p class="text-sm text-gray-500">Performance overview of featured items</p>
                </div>
                <button onclick="refreshCharts()" class="mt-3 sm:mt-0 inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Refresh
                </button>
            </div>
            <div class="h-80">
                <canvas id="monthlyChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Articles by Category Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Content Distribution</h3>
                    <p class="text-sm text-gray-500">Breakdown of your content types</p>
                </div>
                <div class="flex items-center text-sm text-green-600 font-medium mt-3 sm:mt-0">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Live Data
                </div>
            </div>
            <div class="h-80">
                <canvas id="distributionChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Enhanced Recent Activity Tables -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
        @can('view contacts')
        <!-- Recent Contacts -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Contacts</h3>
                    <span class="text-sm text-gray-500">{{ $recentContacts->count() ?? 0 }} total</span>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @if(isset($recentContacts) && $recentContacts->count() > 0)
                    @foreach($recentContacts->take(5) as $contact)
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-white">{{ substr($contact->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $contact->name }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ \Illuminate\Support\Str::limit($contact->subject ?? 'No subject', 40) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @if($contact->status === 'unread')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">New</span>
                                    @endif
                                    <span class="text-xs text-gray-400 whitespace-nowrap">{{ $contact->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No contacts yet</p>
                        <p class="mt-1 text-xs text-gray-400">New contacts will appear here</p>
                    </div>
                @endif
            </div>
            @if(isset($recentContacts) && $recentContacts->count() > 0)
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                    <a href="{{ route('admin.contacts.index') }}" class="flex items-center justify-between text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                        <span>View all contacts</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
        @endcan

        @can('view articles')
        <!-- Recent Articles -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Articles</h3>
                    <span class="text-sm text-gray-500">{{ $recentArticles->count() ?? 0 }} total</span>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @if(isset($recentArticles) && $recentArticles->count() > 0)
                    @foreach($recentArticles->take(5) as $article)
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $article->title }}</p>
                                        <p class="text-sm text-gray-500">by {{ $article->author->name ?? 'System' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @if($article->is_published)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Published</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Draft</span>
                                    @endif
                                    <span class="text-xs text-gray-400 whitespace-nowrap">{{ $article->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No articles yet</p>
                        <p class="mt-1 text-xs text-gray-400">Published articles will appear here</p>
                    </div>
                @endif
            </div>
            @if(isset($recentArticles) && $recentArticles->count() > 0)
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                    <a href="{{ route('admin.articles.index') }}" class="flex items-center justify-between text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                        <span>View all articles</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
        @endcan
    </div>

    <!-- Modern Quick Actions -->
    <div class="bg-gradient-to-br from-slate-50 to-blue-50 border border-slate-200 p-6 lg:p-8 rounded-2xl shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Quick Actions</h3>
                <p class="text-sm text-gray-600">Get started with common tasks</p>
            </div>
            <div class="flex items-center text-sm text-blue-600 font-medium mt-3 sm:mt-0">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Quick Access
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @can('create products')
            <a href="{{ route('admin.products.create') }}"
               class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all duration-300">
                <div class="p-2 bg-blue-50 rounded-lg mr-3 group-hover:bg-blue-100 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Add Product</p>
                    <p class="text-xs text-gray-500">Create new product</p>
                </div>
            </a>
            @endcan

            @can('create articles')
            <a href="{{ route('admin.articles.create') }}"
               class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-emerald-300 hover:shadow-md transition-all duration-300">
                <div class="p-2 bg-emerald-50 rounded-lg mr-3 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Write Article</p>
                    <p class="text-xs text-gray-500">Create content</p>
                </div>
            </a>
            @endcan

            @can('create chatbot')
            <a href="{{ route('admin.chatbot.create') }}"
               class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-md transition-all duration-300">
                <div class="p-2 bg-purple-50 rounded-lg mr-3 group-hover:bg-purple-100 transition-colors">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Chatbot Rule</p>
                    <p class="text-xs text-gray-500">Configure AI</p>
                </div>
            </a>
            @endcan

            @can('view contacts')
            <a href="{{ route('admin.contacts.index') }}"
               class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-md transition-all duration-300">
                <div class="p-2 bg-orange-50 rounded-lg mr-3 group-hover:bg-orange-100 transition-colors">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">View Contacts</p>
                    <p class="text-xs text-gray-500">Check messages</p>
                </div>
            </a>
            @endcan
        </div>
    </div>

    <!-- JavaScript for Charts and Icons -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Chart data from your Laravel stats
        const stats = @json($stats ?? []);

        // Monthly Overview Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Products',
                    data: [stats.total_products || 0, stats.total_products || 0, stats.total_products || 0,
                           stats.total_products || 0, stats.total_products || 0, stats.total_products || 0,
                           stats.total_products || 0, stats.total_products || 0, stats.total_products || 0,
                           stats.total_products || 0, stats.total_products || 0, stats.total_products || 0],
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Articles',
                    data: [0, 0, 0, 0, 0, 0, 0, stats.total_articles || 0, stats.total_articles || 0,
                           stats.total_articles || 0, stats.total_articles || 0, stats.total_articles || 0],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Content Distribution Chart
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        const distributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Products', 'Articles', 'Contacts', 'Chat Sessions'],
                datasets: [{
                    data: [
                        stats.total_products || 0,
                        stats.total_articles || 0,
                        stats.total_contacts || 0,
                        stats.today_chats || 0
                    ],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(250, 204, 21, 0.8)',
                        'rgba(168, 85, 247, 0.8)'
                    ],
                    borderColor: [
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)',
                        'rgb(250, 204, 21)',
                        'rgb(168, 85, 247)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 15,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Refresh charts function
        function refreshCharts() {
            const button = event.target.closest('button');
            button.classList.add('animate-spin');
            button.disabled = true;

            // Simulate data refresh (in real app, you'd fetch new data)
            setTimeout(() => {
                monthlyChart.update();
                distributionChart.update();
                button.classList.remove('animate-spin');
                button.disabled = false;
            }, 1000);
        }

        // Refresh entire dashboard
        function refreshDashboard() {
            const button = event.target.closest('button');
            const originalContent = button.innerHTML;

            button.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i> Refreshing...';
            button.disabled = true;

            // Re-initialize Lucide icons
            setTimeout(() => lucide.createIcons(), 100);

            setTimeout(() => {
                // Refresh charts
                monthlyChart.update();
                distributionChart.update();

                // Restore button
                button.innerHTML = originalContent;
                button.disabled = false;

                // Re-initialize icons again
                setTimeout(() => lucide.createIcons(), 100);
            }, 2000);
        }

        // Re-initialize Lucide icons when content updates
        setInterval(() => {
            lucide.createIcons();
        }, 1000);
    </script>
</x-admin-layout>