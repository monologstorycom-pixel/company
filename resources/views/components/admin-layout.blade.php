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

    <!-- Fallback Fonts -->
    <style>
        @font-face {
            font-family: 'Inter-fallback';
            src: local('Arial'), local('Helvetica Neue'), local('Helvetica');
            ascent-override: 90%;
            descent-override: 20%;
        }
    </style>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Enhanced Cross-Browser Compatible Styles -->
    <style>
        /* CSS Custom Properties for better browser support */
        :root {
            --sidebar-width: 256px;
            --sidebar-transition: cubic-bezier(0.4, 0, 0.2, 1);
            --primary-green: #059669;
            --sidebar-bg-start: #047857;
            --sidebar-bg-end: #065f46;
            --text-primary: #ffffff;
            --text-secondary: #d1fae5;
            --overlay-bg: rgba(0, 0, 0, 0.5);
        }

        /* Enhanced Sidebar Styles */
        .sidebar-link.active {
            background-color: rgba(34, 197, 94, 0.2);
            color: var(--primary-green);
        }

        /* Base Sidebar - Fixed for all desktop screens */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-bg-start) 0%, var(--sidebar-bg-end) 100%);
            z-index: 9999;
            transition: all 0.3s var(--sidebar-transition);
            will-change: transform;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
        }

        /* Enhanced Mobile Styles */
        @media (max-width: 767px) {
            .sidebar {
                -webkit-transform: translateX(-100%);
                -ms-transform: translateX(-100%);
                transform: translateX(-100%);
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }

            .sidebar.open {
                -webkit-transform: translateX(0);
                -ms-transform: translateX(0);
                transform: translateX(0);
            }

            /* Prevent content jump when sidebar opens */
            body.sidebar-open {
                overflow: hidden;
                position: fixed;
                width: 100%;
            }
        }

        /* Tablet Styles */
        @media (min-width: 768px) and (max-width: 1023px) {
            .sidebar {
                width: 280px; /* Wider on tablets for better touch interaction */
            }

            .main-content {
                margin-left: 280px;
            }
        }

        /* Desktop Styles */
        @media (min-width: 1024px) {
            .sidebar {
                -webkit-transform: translateX(0);
                -ms-transform: translateX(0);
                transform: translateX(0);
            }

            .main-content {
                margin-left: var(--sidebar-width);
            }
        }

        /* Enhanced Main Content */
        .main-content {
            min-height: 100vh;
            transition: margin-left 0.3s var(--sidebar-transition);
            -webkit-transition: margin-left 0.3s var(--sidebar-transition);
        }

        /* Overlay Enhancement */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: var(--overlay-bg);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            -webkit-backdrop-filter: blur(2px);
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Enhanced Animations */
        .sidebar-link {
            position: relative;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar-link:hover::before {
            left: 100%;
        }

        /* Cross-browser scrollbar styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Firefox scrollbar */
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) rgba(255, 255, 255, 0.1);
        }

        /* Enhanced Touch Targets for Mobile/Tablet */
        @media (max-width: 1023px) {
            .sidebar-link {
                padding: 12px 20px;
                margin: 4px 8px;
            }

            .sidebar .mobile-menu-btn {
                padding: 12px;
                margin: 8px;
            }
        }

        /* Print Styles */
        @media print {
            .sidebar, .sidebar-overlay {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
            }
        }

        /* High Contrast Mode Support */
        @media (prefers-contrast: high) {
            .sidebar {
                background: #000;
            }

            .sidebar-link {
                border: 1px solid #fff;
            }
        }

        /* Reduced Motion Support */
        @media (prefers-reduced-motion: reduce) {
            .sidebar,
            .sidebar-overlay,
            .sidebar-link,
            .main-content {
                transition: none !important;
                animation: none !important;
            }
        }

        /* Enhanced Focus Styles for Accessibility */
        .sidebar-link:focus-visible {
            outline: 2px solid #fff;
            outline-offset: 2px;
            border-radius: 8px;
        }

        /* Safari specific fixes */
        @supports (-webkit-appearance: none) {
            .sidebar {
                -webkit-transform: translateZ(0);
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased" style="font-family: 'Inter', 'Inter-fallback', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div class="min-h-screen flex">
        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" class="sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Enhanced Sidebar -->
        <aside id="sidebar" class="sidebar text-white py-6 px-4 overflow-y-auto shadow-2xl" role="navigation" aria-label="Main navigation">
            <div class="mb-8 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="building-2" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">PT Lestari Jaya Bangsa</h1>
                        <p class="text-green-200 text-sm font-medium">Admin Panel</p>
                    </div>
                </div>
                <!-- Mobile close button -->
                <button onclick="closeSidebar()" class="mobile-menu-btn md:hidden text-white hover:text-green-200 p-2 rounded-lg hover:bg-green-700 transition-colors" aria-label="Close sidebar">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Search Bar (Optional) -->
            <div class="mb-6 relative">
                <input type="text"
                       placeholder="Search menu..."
                       role="searchbox"
                       aria-label="Search menu items"
                       class="w-full px-4 py-2 pl-10 bg-white/10 border border-white/20 rounded-xl text-white placeholder-green-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent focus:bg-white/20 transition-all duration-200">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-2.5 text-green-200 pointer-events-none"></i>
            </div>

            <nav class="space-y-1 pb-24" role="menubar" aria-label="Main navigation menu">
                <!-- Menu Section Label -->
                <div class="text-green-300/70 text-xs font-semibold uppercase tracking-wider px-4 py-2 mb-2">Main Menu</div>

                <!-- Dashboard - All roles -->
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link group flex items-center py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 shadow-lg text-white' : 'hover:bg-white/10 text-green-100' }}"
                   role="menuitem"
                   aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}">
                    <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-colors mr-3">
                        <i data-lucide="layout-dashboard" class="w-5 h-5" aria-hidden="true"></i>
                    </div>
                    <span class="font-medium flex-1">Dashboard</span>
                    @if(request()->routeIs('admin.dashboard'))
                        <i data-lucide="chevron-right" class="w-4 h-4 text-green-300" aria-hidden="true"></i>
                    @endif
                </a>

                <!-- Products - Super Admin, Admin -->
                @can('view products')
                <a href="{{ route('admin.products.index') }}"
                   class="sidebar-link group flex items-center py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-white/20 shadow-lg text-white' : 'hover:bg-white/10 text-green-100' }}">
                    <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-colors mr-3">
                        <i data-lucide="package" class="w-5 h-5"></i>
                    </div>
                    <span class="font-medium flex-1">Products</span>
                    @if(request()->routeIs('admin.products.*'))
                        <i data-lucide="chevron-right" class="w-4 h-4 text-green-300"></i>
                    @endif
                </a>
                @endcan

                <!-- Articles - Super Admin, Admin, Marketing -->
                @can('view articles')
                <a href="{{ route('admin.articles.index') }}"
                   class="sidebar-link group flex items-center py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.articles.*') ? 'bg-white/20 shadow-lg text-white' : 'hover:bg-white/10 text-green-100' }}">
                    <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ request()->routeIs('admin.articles.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-colors mr-3">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                    <span class="font-medium flex-1">Articles</span>
                    @if(request()->routeIs('admin.articles.*'))
                        <i data-lucide="chevron-right" class="w-4 h-4 text-green-300"></i>
                    @endif
                </a>
                @endcan

                <!-- Contacts - Super Admin, Admin -->
                @can('view contacts')
                @php
                    $unreadCount = \App\Models\Contact::where('status', 'unread')->count();
                @endphp
                <a href="{{ route('admin.contacts.index') }}"
                   class="sidebar-link group flex items-center py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.contacts.*') ? 'bg-white/20 shadow-lg text-white' : 'hover:bg-white/10 text-green-100' }}">
                    <div class="relative flex items-center justify-center w-9 h-9 rounded-lg {{ request()->routeIs('admin.contacts.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-colors mr-3">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-green-700 animate-pulse"></span>
                        @endif
                    </div>
                    <span class="font-medium flex-1">Contacts</span>
                    @if($unreadCount > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full font-bold min-w-[20px] text-center">{{ $unreadCount }}</span>
                    @elseif(request()->routeIs('admin.contacts.*'))
                        <i data-lucide="chevron-right" class="w-4 h-4 text-green-300"></i>
                    @endif
                </a>
                @endcan

                <!-- Chatbot Section -->
                @can('view chatbot')
                <div class="mt-6">
                    <div class="text-green-300/70 text-xs font-semibold uppercase tracking-wider px-4 py-2 mb-2">Chatbot</div>
                    
                    @can('create chatbot')
                    <a href="{{ route('admin.chatbot.index') }}"
                       class="sidebar-link group flex items-center py-2.5 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.chatbot.index') || request()->routeIs('admin.chatbot.create') || request()->routeIs('admin.chatbot.edit') ? 'bg-white/20 shadow-lg text-white' : 'hover:bg-white/10 text-green-100' }}">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.chatbot.index') || request()->routeIs('admin.chatbot.create') || request()->routeIs('admin.chatbot.edit') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-colors mr-3">
                            <i data-lucide="bot" class="w-4 h-4"></i>
                        </div>
                        <span class="text-sm font-medium flex-1">Rules</span>
                        @if(request()->routeIs('admin.chatbot.index') || request()->routeIs('admin.chatbot.create') || request()->routeIs('admin.chatbot.edit'))
                            <i data-lucide="chevron-right" class="w-4 h-4 text-green-300"></i>
                        @endif
                    </a>
                    @endcan
                    
                    <a href="{{ route('admin.chatbot.history') }}"
                       class="sidebar-link group flex items-center py-2.5 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.chatbot.history') ? 'bg-white/20 shadow-lg text-white' : 'hover:bg-white/10 text-green-100' }}">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.chatbot.history') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-colors mr-3">
                            <i data-lucide="history" class="w-4 h-4"></i>
                        </div>
                        <span class="text-sm font-medium flex-1">History</span>
                        @if(request()->routeIs('admin.chatbot.history'))
                            <i data-lucide="chevron-right" class="w-4 h-4 text-green-300"></i>
                        @endif
                    </a>
                </div>
                @endcan

                <!-- Administration Section -->
                @canany(['view users', 'view roles', 'view settings'])
                <div class="mt-6">
                    <div class="text-green-300/70 text-xs font-semibold uppercase tracking-wider px-4 py-2 mb-2">Administration</div>

                    <!-- Users - Super Admin Only -->
                    @can('view users')
                    <a href="{{ route('admin.users.index') }}"
                       class="sidebar-link group flex items-center py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white/20 shadow-lg text-white' : 'hover:bg-white/10 text-green-100' }}">
                        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-colors mr-3">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                        <span class="font-medium flex-1">Users</span>
                        @if(request()->routeIs('admin.users.*'))
                            <i data-lucide="chevron-right" class="w-4 h-4 text-green-300"></i>
                        @endif
                    </a>
                    @endcan

                    <!-- Roles & Permissions - Super Admin Only -->
                    @can('view roles')
                    <a href="{{ route('admin.roles.index') }}"
                       class="sidebar-link group flex items-center py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-white/20 shadow-lg text-white' : 'hover:bg-white/10 text-green-100' }}">
                        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ request()->routeIs('admin.roles.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-colors mr-3">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <span class="font-medium flex-1">Roles</span>
                        @if(request()->routeIs('admin.roles.*'))
                            <i data-lucide="chevron-right" class="w-4 h-4 text-green-300"></i>
                        @endif
                    </a>
                    @endcan

                    <!-- Settings - Super Admin Only -->
                    @can('view settings')
                    <a href="{{ route('admin.settings.index') }}"
                       class="sidebar-link group flex items-center py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-white/20 shadow-lg text-white' : 'hover:bg-white/10 text-green-100' }}">
                        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-colors mr-3">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                        </div>
                        <span class="font-medium flex-1">Settings</span>
                        @if(request()->routeIs('admin.settings.*'))
                            <i data-lucide="chevron-right" class="w-4 h-4 text-green-300"></i>
                        @endif
                    </a>
                    @endcan
                </div>
                @endcanany
            </nav>

            <!-- Enhanced User Info -->
            <div class="absolute bottom-6 left-4 right-4">
                <div class="bg-gradient-to-r from-green-700 to-green-600 rounded-xl p-4 shadow-lg border border-green-500/30">
                    <div class="flex items-center mb-4">
                        <div class="relative">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-lg font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-green-700"></div>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-green-200 truncate font-medium">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('home') }}" target="_blank"
                           class="flex-1 bg-white/10 hover:bg-white/20 text-white text-sm py-2 px-3 rounded-lg text-center transition-all duration-200 backdrop-blur-sm border border-white/20 font-medium">
                            <i data-lucide="external-link" class="w-3 h-3 inline mr-1"></i>
                            Site
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-red-500/80 hover:bg-red-500 text-white text-sm py-2 px-3 rounded-lg transition-all duration-200 backdrop-blur-sm border border-red-400/30 font-medium">
                                <i data-lucide="log-out" class="w-3 h-3 inline mr-1"></i>
                                Exit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <div class="main-content flex-1">
            <!-- Enhanced Top bar -->
            <header class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-30 backdrop-blur-sm bg-white/95">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <!-- Mobile menu button -->
                            <button onclick="openSidebar()" class="mobile-menu-btn md:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" aria-label="Open sidebar">
                                <i data-lucide="menu" class="w-6 h-6"></i>
                            </button>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
                                <p class="text-sm text-gray-500 hidden sm:block">{{ now()->format('l, F j, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative hidden sm:block">
                                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                                    <i data-lucide="bell" class="w-5 h-5"></i>
                                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                                </button>
                            </div>
                            <!-- User welcome -->
                            <div class="hidden md:flex items-center space-x-3 bg-gray-50 px-4 py-2 rounded-lg border border-gray-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Enhanced Page content -->
            <main class="p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
                @if(session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg mb-6 flex items-center justify-between shadow-sm animate-pulse-once">
                        <div class="flex items-center">
                            <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-green-600"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800 ml-4 p-1 hover:bg-green-100 rounded transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-lg mb-6 flex items-center justify-between shadow-sm">
                        <div class="flex items-center">
                            <i data-lucide="alert-circle" class="w-5 h-5 mr-3 text-red-600"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800 ml-4 p-1 hover:bg-red-100 rounded transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-lg mb-6 shadow-sm">
                        <div class="flex items-start">
                            <i data-lucide="alert-triangle" class="w-5 h-5 mr-3 text-red-600 mt-0.5"></i>
                            <div>
                                <p class="font-semibold mb-2">Please fix the following errors:</p>
                                <ul class="list-disc list-inside space-y-1 text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        // Enhanced cross-browser compatible sidebar functionality
        (function() {
            'use strict';

            // Cache DOM elements
            let sidebar, overlay, body;
            let isInitialized = false;
            let lucideInterval;

            // Initialize elements
            function initElements() {
                sidebar = document.getElementById('sidebar');
                overlay = document.getElementById('sidebar-overlay');
                body = document.body;
                isInitialized = true;
            }

            // Enhanced open sidebar function
            function openSidebar() {
                if (!isInitialized) initElements();

                // Add classes for mobile
                if (window.innerWidth < 768) {
                    sidebar.classList.add('open');
                    overlay.classList.add('active');
                    body.classList.add('sidebar-open');

                    // Focus management for accessibility
                    setTimeout(() => {
                        sidebar.focus();
                    }, 100);
                }

                reinitializeIcons();
            }

            // Enhanced close sidebar function
            function closeSidebar() {
                if (!isInitialized) initElements();

                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                body.classList.remove('sidebar-open');

                reinitializeIcons();
            }

            // Toggle sidebar function (for backwards compatibility)
            function toggleSidebar() {
                if (!isInitialized) initElements();

                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }

            // Enhanced keyboard navigation
            function handleKeyboard(e) {
                if (e.key === 'Escape') {
                    closeSidebar();
                }

                // Handle arrow key navigation in sidebar
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    if (!sidebar.contains(document.activeElement)) return;

                    const links = sidebar.querySelectorAll('a[role="menuitem"]');
                    const currentIndex = Array.from(links).indexOf(document.activeElement);
                    let nextIndex;

                    if (e.key === 'ArrowDown') {
                        nextIndex = (currentIndex + 1) % links.length;
                    } else {
                        nextIndex = currentIndex - 1 < 0 ? links.length - 1 : currentIndex - 1;
                    }

                    links[nextIndex].focus();
                    e.preventDefault();
                }
            }

            // Handle window resize
            function handleResize() {
                if (window.innerWidth >= 768) {
                    closeSidebar(); // Auto-close on desktop
                }
            }

            // Enhanced icon reinitialization
            function reinitializeIcons() {
                if (typeof lucide !== 'undefined') {
                    setTimeout(() => {
                        try {
                            lucide.createIcons();
                        } catch (e) {
                            console.warn('Failed to reinitialize Lucide icons:', e);
                        }
                    }, 50);
                }
            }

            // Enhanced click feedback with touch support
            function addClickFeedback(e) {
                const element = e.target.closest('button, .sidebar-link, a');
                if (!element) return;

                // Skip for file inputs and similar elements
                if (element.type === 'file' || element.tagName === 'INPUT') return;

                // Add active class for better feedback
                element.classList.add('active');

                // Handle touch events
                if (e.type === 'touchstart') {
                    setTimeout(() => {
                        element.classList.remove('active');
                    }, 150);
                } else {
                    setTimeout(() => {
                        element.classList.remove('active');
                    }, 100);
                }
            }

            // Auto-hide alerts with better performance
            function autoHideAlerts() {
                const alerts = document.querySelectorAll('[class*="bg-gradient-to-r"].from-green-50, [class*="bg-gradient-to-r"].from-red-50');

                alerts.forEach((alert, index) => {
                    setTimeout(() => {
                        alert.style.transition = 'opacity 0.3s ease';
                        alert.style.opacity = '0';

                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.parentNode.removeChild(alert);
                            }
                        }, 300);
                    }, 5000 + (index * 200)); // Stagger the hiding
                });
            }

            // Add active button styles
            function addActiveStyles() {
                const style = document.createElement('style');
                style.textContent = `
                    .sidebar-link.active:active,
                    button:active,
                    .sidebar-link:active {
                        transform: scale(0.98) !important;
                        opacity: 0.8 !important;
                    }
                `;
                document.head.appendChild(style);
            }

            // Enhanced initialization on DOM ready
            function init() {
                initElements();

                // Event listeners with passive option for better performance
                document.addEventListener('keydown', handleKeyboard, { passive: false });
                window.addEventListener('resize', handleResize, { passive: true });
                document.addEventListener('click', addClickFeedback, { passive: true });
                document.addEventListener('touchstart', addClickFeedback, { passive: true });

                // Initialize Lucide icons
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();

                    // Periodic icon refresh for dynamic content
                    lucideInterval = setInterval(() => {
                        reinitializeIcons();
                    }, 2000);
                }

                // Auto-hide alerts
                setTimeout(autoHideAlerts, 1000);

                // Add active styles
                addActiveStyles();

                // Handle initial state
                if (window.innerWidth >= 768) {
                    // Desktop: ensure sidebar is visible
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                    body.classList.remove('sidebar-open');
                }

                console.log('Enhanced sidebar initialized successfully');
            }

            // Make functions globally available
            window.openSidebar = openSidebar;
            window.closeSidebar = closeSidebar;
            window.toggleSidebar = toggleSidebar;

            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }

            // Cleanup on page unload
            window.addEventListener('beforeunload', () => {
                if (lucideInterval) {
                    clearInterval(lucideInterval);
                }
            });
        })();
    </script>
</body>
</html>
