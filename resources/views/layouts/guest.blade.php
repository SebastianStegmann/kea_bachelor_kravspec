<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md flex flex-col items-center">
            <div class="w-full flex justify-center mb-4">
                <a href="{{config('app.short_url')}}">
                    <x-application-logo class="w-64 fill-current"  />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
