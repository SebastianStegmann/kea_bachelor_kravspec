<x-guest-layout>
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-900">Kravspec </h1>

<div class="space-y-2 mb-12">
            @auth


<a  href="{{ route('home') }}" class=" text-center block px-4 py-3 bg-[hsl(129,28%,29%)] border border-transparent rounded-lg font-medium text-white hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition w-full" tabindex="0">
Dashboard
</a>
            @else

<a  href="{{ route('login') }}" class=" text-center block px-4 py-3 bg-[hsl(129,28%,29%)] border border-transparent rounded-lg font-medium text-white hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition w-full" tabindex="0">
Login
</a>

<a  href="{{ route('register') }}" class=" text-center block px-4 py-3 bg-[hsl(129,28%,29%)] border border-transparent rounded-lg font-medium text-white hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition w-full" tabindex="0">
Register
</a>
            @endauth
</div>

</x-guest-layout>
