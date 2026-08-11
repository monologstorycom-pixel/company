<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Panel' }} - PT Lestari Jaya Bangsa</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        .sidebar-link.active {
            background-color: rgba(34, 197, 94, 0.2);
            color: #16a34a;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-green-800 text-white w-64 py-6 px-4 fixed h-full overflow-y-auto">
            <div class="mb-8">
                <h1 class="text-xl font-bold">PT Lestari Jaya Bangsa</h1>
                <p class="text-green-200 text-sm">Admin Panel</p>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link block py-3 px-4 rounded-lg hover:bg-green-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/>
                    </svg>
                    Dashboard
                </a>

                @can('view products')
                <a href="{{ route('admin.products.index') }}"
                   class="sidebar-link block py-3 px-4 rounded-lg hover:bg-green-700 transition-colors {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Products
                </a>
                @endcan

                @can('view articles')
                <a href="{{ route('admin.articles.index') }}"
                   class="sidebar-link block py-3 px-4 rounded-lg hover:bg-green-700 transition-colors {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Articles
                </a>
                @endcan

                @can('view contacts')
                <a href="{{ route('admin.contacts.index') }}"
                   class="sidebar-link block py-3 px-4 rounded-lg hover:bg-green-700 transition-colors {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Contacts
                </a>
                @endcan

                @can('view chatbot')
                <div class="space-y-1">
                    <div class="text-green-200 text-sm font-medium px-4 py-2">Chatbot</div>
                    @can('create chatbot')
                    <a href="{{ route('admin.chatbot.index') }}"
                       class="sidebar-link block py-2 px-6 rounded-lg hover:bg-green-700 transition-colors {{ request()->routeIs('admin.chatbot.index') || request()->routeIs('admin.chatbot.create') || request()->routeIs('admin.chatbot.edit') ? 'active' : '' }}">
                        Rules
                    </a>
                    @endcan
                    <a href="{{ route('admin.chatbot.history') }}"
                       class="sidebar-link block py-2 px-6 rounded-lg hover:bg-green-700 transition-colors {{ request()->routeIs('admin.chatbot.history') ? 'active' : '' }}">
                        History
                    </a>
                </div>
                @endcan

                @can('view users')
                <a href="#"
                   class="sidebar-link block py-3 px-4 rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Users
                </a>
                @endcan

                @can('view settings')
                <a href="#"
                   class="sidebar-link block py-3 px-4 rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-5 h-5 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
                @endcan
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-6 left-4 right-4">
                <div class="bg-green-700 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                            <span class="text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-green-200">{{ auth()->user()->getRoleNames()->first() }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-sm py-2 px-4 rounded transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 ml-64">
            <!-- Top bar -->
            <div class="bg-white shadow-sm px-8 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $title ?? 'Dashboard' }}</h2>
                    <div class="text-sm text-gray-600">
                        Welcome back, {{ auth()->user()->name }}!
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <div class="p-8">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>

</body>
</html>