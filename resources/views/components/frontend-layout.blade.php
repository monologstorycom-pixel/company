<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title : 'PT Lestari Jaya Bangsa - Food & Herbal Products' }} | {{ config('app.name', 'Lestari Jaya Bangsa') }}</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ isset($metaDescription) ? $metaDescription : 'PT Lestari Jaya Bangsa menyediakan produk herbal dan makanan olahan berkualitas tinggi, berkomitmen memprioritaskan kesehatan dan rasa. Berdiri sejak 1992.' }}">
    <meta name="keywords" content="produk herbal, makanan olahan, bahan alami, sertifikat BPOM, Halal MUI, PT Lestari Jaya Bangsa, food & herbal">
    <meta name="author" content="PT Lestari Jaya Bangsa">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ isset($title) ? $title : 'PT Lestari Jaya Bangsa - Food & Herbal Products' }}">
    <meta property="og:description" content="{{ isset($metaDescription) ? $metaDescription : 'PT Lestari Jaya Bangsa menyediakan produk herbal dan makanan olahan berkualitas tinggi.' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="PT Lestari Jaya Bangsa">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ isset($title) ? $title : 'PT Lestari Jaya Bangsa' }}">
    <meta name="twitter:description" content="{{ isset($metaDescription) ? $metaDescription : 'Produk herbal dan makanan olahan berkualitas tinggi' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 min-h-screen flex flex-col">
    <!-- Navigation -->
    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow pt-16 md:pt-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Chatbot Widget -->
    <x-chatbot-widget />

    <!-- Scroll to Top Button -->
    <button 
        id="scroll-top-btn"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="scroll-top"
        aria-label="Scroll to top">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <!-- Scroll to Top Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scrollTopBtn = document.getElementById('scroll-top-btn');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollTopBtn.classList.add('visible');
                } else {
                    scrollTopBtn.classList.remove('visible');
                }
            });
        });
    </script>
</body>
</html>