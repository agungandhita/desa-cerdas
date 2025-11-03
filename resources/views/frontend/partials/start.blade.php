<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Basic Meta Tags --}}
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="@yield('meta_description', 'Sistem Informasi Desa Cerdas - Platform digital untuk pelayanan masyarakat desa yang efisien dan transparan')" />
    <meta name="keywords" content="@yield('meta_keywords', 'desa cerdas, sistem informasi desa, pelayanan publik, transparansi desa, digitalisasi desa')" />
    <meta name="author" content="Desa Cerdas" />
    <meta name="robots" content="index, follow" />
    
    {{-- Open Graph Meta Tags --}}
    <meta property="og:title" content="@yield('og_title', config('app.name'))" />
    <meta property="og:description" content="@yield('og_description', 'Sistem Informasi Desa Cerdas - Platform digital untuk pelayanan masyarakat desa')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="@yield('og_image', asset('images/desa-cerdas-logo.png'))" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    
    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name'))" />
    <meta name="twitter:description" content="@yield('twitter_description', 'Sistem Informasi Desa Cerdas')" />
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/desa-cerdas-logo.png'))" />
    
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}" />
    
    {{-- Page Title --}}
    <title>@yield('title', config('app.name')) - @yield('subtitle', 'Sistem Informasi Desa')</title>
    
    {{-- Preconnect for Performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" />
    
    {{-- CSS Styles --}}
    @vite('resources/css/app.css')
    
    {{-- External CSS Libraries --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    
    {{-- Additional Styles --}}
    @stack('styles')
    
    {{-- Custom CSS --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .bg-main {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Loading animation */
        .loading {
            opacity: 0;
            animation: fadeIn 0.5s ease-in-out forwards;
        }
        
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-main loading antialiased">
    {{-- Loading Indicator --}}
    <div id="loading-indicator" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            <p class="mt-4 text-gray-600 text-sm">Memuat halaman...</p>
        </div>
    </div>
    
    {{-- Skip to main content for accessibility --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-50">
        Skip to main content
    </a>
