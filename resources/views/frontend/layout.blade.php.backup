<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'PT Lestari Jaya Bangsa') }}</title>

    <!-- Enhanced SEO Meta Tags -->
    <meta name="description" content="{{ $metaDescription ?? 'PT Lestari Jaya Bangsa provides high-quality herbal and processed food products, committed to prioritizing both health and taste.' }}">
    <meta name="keywords" content="herbal products, food products, natural ingredients, BPOM certified, Halal MUI, PT Lestari Jaya Bangsa, kesehatan, makanan herbal, produk alami">
    <meta name="author" content="PT Lestari Jaya Bangsa">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="language" content="Indonesian">
    <meta name="revisit-after" content="7 days">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? config('app.name', 'PT Lestari Jaya Bangsa') }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'PT Lestari Jaya Bangsa provides high-quality herbal and processed food products.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="PT Lestari Jaya Bangsa">
    <meta property="og:locale" content="id_ID">
    @if(isset($ogImage))
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:type" content="image/jpeg">
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? config('app.name', 'PT Lestari Jaya Bangsa') }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? 'PT Lestari Jaya Bangsa provides high-quality herbal and processed food products.' }}">
    @if(isset($ogImage))
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif

    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#10b981">
    <meta name="msapplication-TileColor" content="#10b981">
    <meta name="application-name" content="PT Lestari Jaya Bangsa">
    <meta name="apple-mobile-web-app-title" content="PT Lestari Jaya Bangsa">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- DNS Prefetch for Performance -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">

    <!-- Preconnect for Critical Resources -->
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }
        .certification-badge {
            background: linear-gradient(45deg, #22c55e, #16a34a);
            box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span class="text-2xl font-bold text-green-600">PT Lestari Jaya Bangsa</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'text-green-600' : '' }}">Home</a>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('products.*') ? 'text-green-600' : '' }}">Products</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('about') ? 'text-green-600' : '' }}">About</a>
                    <a href="{{ route('articles.index') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('articles.*') ? 'text-green-600' : '' }}">Articles</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('contact') ? 'text-green-600' : '' }}">Contact</a>
                </div>

                <div class="flex items-center">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

      <!-- Footer Component -->
    <x-footer />

    <!-- Chatbot Component -->
    <x-chatbot />

  <!-- Optimized JavaScript for Alpine.js Compatibility -->
    <script>
        // Wait for Alpine.js to be ready
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized');
        });

        // Enhanced smooth scroll for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading states for forms
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        const originalText = submitBtn.textContent;
                        submitBtn.innerHTML = `
                            <span class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </span>
                        `;

                        // Reset button after 10 seconds in case of error
                        setTimeout(function() {
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            submitBtn.textContent = originalText;
                        }, 10000);
                    }
                });
            });
        });

        // Error handling for debugging
        window.addEventListener('error', function(e) {
            console.error('JavaScript error:', e.error);
        });

        // Performance monitoring
        if ('performance' in window) {
            window.addEventListener('load', function() {
                const perfData = window.performance.timing;
                const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
                console.log('Page load time:', pageLoadTime + 'ms');
            });
        }
    </script>
</body>
</html>