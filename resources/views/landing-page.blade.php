
   {{-- <x-guest-layout>

        <h1 class="text-3xl font-bold text-center mb-6 text-gray-900">Kravspec</h1>
            <a href="{{ route('home') }}" class="block w-full px-4 py-2 text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300">
                Go to app
            </a>
</x-guest-layout>
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

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
<body class="antialiased">
   <div class="min-h-screen bg-white">
       <!-- Navigation -->
       <nav class="px-6 border-b">
           <div class="container mx-auto flex justify-between items-center">
               <div class="flex items-center ">
                   <x-application-logo class="h-16 fill-current text-gray-800" />
                   <span class="text-xl font-semibold">{{ config('app.name') }}</span>
               </div>
               <a href="{{ route('home') }}"
                  class="px-6 py-2 rounded-lg bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] text-white font-medium transition">
                   Go to app
               </a>
           </div>
       </nav>

       <!-- Hero Section -->
       <div class="container mx-auto px-6 py-24 text-center">
           <h1 class="text-5xl font-bold tracking-tight">
               Requirement Evolution,<br>Crystal Clear
           </h1>
           <p class="mt-6 text-xl text-gray-600 max-w-2xl mx-auto">
               Track, trace, and understand how your requirements evolve throughout your project's lifecycle
           </p>
           <div class="mt-12">
               <a href="{{ route('home') }}"
                  class="px-8 py-3 rounded-lg bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] text-white font-medium text-lg transition">
                   Start Tracking Changes
               </a>
           </div>
       </div>

       <!-- Features Grid -->
       <div class="bg-gray-50 py-24">
           <div class="container mx-auto px-6">
               <div class="grid md:grid-cols-3 gap-12">
                   <div class="text-center p-6">
                       <div class="w-12 h-12 bg-[hsl(129,28%,29%)] bg-opacity-10 rounded-xl flex items-center justify-center mx-auto">
                           <svg class="w-6 h-6 text-[hsl(129,28%,29%)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                           </svg>
                       </div>
                       <h3 class="mt-4 text-xl font-semibold">Change Tracking</h3>
                       <p class="mt-2 text-gray-600">Every change is recorded and easily accessible. See who changed what and when, with clear, visual diffs.</p>
                   </div>

                   <div class="text-center p-6">
                       <div class="w-12 h-12 bg-[hsl(129,28%,29%)] bg-opacity-10 rounded-xl flex items-center justify-center mx-auto">
                           <svg class="w-6 h-6 text-[hsl(129,28%,29%)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                           </svg>
                       </div>
                       <h3 class="mt-4 text-xl font-semibold">Requirements Timeline</h3>
                       <p class="mt-2 text-gray-600">Navigate through the complete history of your requirements. Understand how specifications evolved from inception to delivery.</p>
                   </div>

                   <div class="text-center p-6">
                       <div class="w-12 h-12 bg-[hsl(129,28%,29%)] bg-opacity-10 rounded-xl flex items-center justify-center mx-auto">
                           <svg class="w-6 h-6 text-[hsl(129,28%,29%)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                           </svg>
                       </div>
                       <h3 class="mt-4 text-xl font-semibold">Intuitive Interface</h3>
                       <p class="mt-2 text-gray-600">Start documenting requirements immediately with our clean, straightforward interface designed for both business and technical users.</p>
                   </div>
               </div>
           </div>
       </div>

       <!-- Additional Benefits -->
<!-- Additional Benefits -->
<div class="container mx-auto px-6 py-24">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-16">Core Features</h2>
        <div class="grid gap-8">
            <div class="flex items-start gap-4">
                <div class="w-8 h-8 bg-[hsl(129,28%,29%)] bg-opacity-10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-[hsl(129,28%,29%)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Clear History</h3>
                    <p class="text-gray-600 mt-1">View a chronological log of every change made to a requirement, with timestamps.</p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-8 h-8 bg-[hsl(129,28%,29%)] bg-opacity-10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-[hsl(129,28%,29%)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Version Control</h3>
                    <p class="text-gray-600 mt-1">Each change creates a new version, making it easy to reference specific points in a requirement's history.</p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-8 h-8 bg-[hsl(129,28%,29%)] bg-opacity-10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-[hsl(129,28%,29%)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Instant Access</h3>
                    <p class="text-gray-600 mt-1">Quick access to any historical version of a requirement without complex navigation.</p>
                </div>
            </div>
        </div>
    </div>
</div>
       <!-- Footer -->
       <footer class="border-t">
           <div class="container mx-auto px-6 py-8">
               <div class="flex justify-between items-center">
                   <div class="flex items-center gap-2">
                       <x-application-logo class="h-8 w-auto" />
                       <span class="text-gray-600">© {{ date('Y') }} {{ config('app.name') }}</span>
                   </div>
                   <a href="{{ route('home') }}" class="text-[hsl(129,28%,29%)] hover:underline">
                       Go to app →
                   </a>
               </div>
           </div>
       </footer>
   </div>
</body>
</html>
