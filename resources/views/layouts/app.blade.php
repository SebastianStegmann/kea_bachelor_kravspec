<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title>{{ config('app.name', 'Kravspec') }} - Collaborative Specification Management</title>
    <meta name="title" content="{{ config('app.name', 'Kravspec') }} - Collaborative Specification Management">
    <meta name="description" content="Streamline your specification process with Kravspec. Collaborate on requirements, track changes, and manage versions in real-time with your team.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="{{ config('app.name', 'Kravspec') }} - Collaborative Specification Management">
    <meta property="og:description" content="Streamline your specification process with Kravspec. Collaborate on requirements, track changes, and manage versions in real-time with your team.">
    <meta property="og:image" content="{{ asset('og-image.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ config('app.url') }}">
    <meta property="twitter:title" content="{{ config('app.name', 'Kravspec') }} - Collaborative Specification Management">
    <meta property="twitter:description" content="Streamline your specification process with Kravspec. Collaborate on requirements, track changes, and manage versions in real-time with your team.">
    <meta property="twitter:image" content="{{ asset('og-image.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{asset('apple-touch-icon.png')}}">

    <!-- HTMX -->
    <script src="https://unpkg.com/htmx.org@2.0.3" defer></script>
    <!-- Tailwind -->
     <script src="https://cdn.tailwindcss.com"></script>


</head>

<body class="font-sans antialiased">
    <div id="toast-container"
             class="fixed top-4 right-4 z-50 space-y-2">
        </div>
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <!-- <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header> -->
        @endisset

        <!-- Page Content -->
        <main >
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            {{ $slot }}
                    </div>
                </div>
            </div>
        </main>
    </div>
    <x-htmx-error-handler />
</body>


<style>
    .htmx-settling {
        opacity: 1;
    }
    .htmx-request {
        opacity: 0.5;
        transition: opacity 200ms ease-in-out;
    }
    #toast-container > div {
        opacity: 0;
        transform: translateY(-20px);
        animation: slideIn 0.3s ease forwards;
    }
    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    #toast-container > div[hx-trigger*="load"] {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    #toast-container > div[hx-trigger*="load"].htmx-swapping {
        opacity: 0;
        transform: translateY(-20px);
    }
</style>
</html>
