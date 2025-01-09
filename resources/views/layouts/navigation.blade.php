<nav class="bg-white border-b border-gray-100" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left side navigation -->
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ENV('APP_SHORT_URL')}}"
                   class="shrink-0 focus:outline-none focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:ring-offset-2 rounded-lg"
                   tabindex="0">
                    <x-application-logo class="block h-16 w-auto fill-current text-gray-800" />
                </a>

                <!-- Primary Navigation Links -->
                <a href="#"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('specs.index') ? 'text-[hsl(129,28%,29%)]' : 'text-gray-500 hover:text-gray-700' }} focus:outline-none focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:ring-offset-2 rounded-lg transition"
                   hx-get="/"
                   hx-target="#specs-container"
                   hx-swap="outerHTML"
                   hx-push-url="true"
                   tabindex="0">
                    Specifications
                </a>
            </div>

            <!-- User Navigation -->
            <div class="flex items-center">
                <!-- Desktop User Menu -->
                <div class="hidden sm:block">
                    <details class="relative dropdown">
                        <summary
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:ring-offset-2 transition cursor-pointer list-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </summary>

                        <div class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                            <nav aria-label="User menu" class="py-1">
                                <a href="#"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                   hx-get="{{ route('profile.edit') }}"
                                   hx-target="#specs-container"
                                   hx-swap="outerHTML"
                                   hx-push-url="true">
                                    {{ __('Profile') }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </nav>
                        </div>
                    </details>
                </div>

                <!-- Mobile Menu -->
                <div class="sm:hidden">
                    <details class="relative">
                        <summary
                            class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:ring-offset-2 transition cursor-pointer list-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </summary>

                        <div class="fixed inset-0 z-10 w-full bg-white">
                            <nav aria-label="Mobile menu" class="h-full divide-y divide-gray-200">
                                <div class="px-4 py-6">
                                    <a href="#"
                                       class="block text-base font-medium text-gray-900 hover:text-[hsl(129,28%,29%)]"
                                       hx-get="/"
                                       hx-target="#specs-container"
                                       hx-swap="outerHTML"
                                       hx-push-url="true">
                                        {{ __('Specifications') }}
                                    </a>
                                </div>
                                <div class="px-4 py-6">
                                    <div class="mb-4">
                                        <p class="text-base font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="#"
                                       class="block mb-2 text-base font-medium text-gray-900 hover:text-[hsl(129,28%,29%)]"
                                       hx-get="{{ route('profile.edit') }}"
                                       hx-target="#specs-container"
                                       hx-swap="outerHTML"
                                       hx-push-url="true">
                                        {{ __('Profile') }}
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                class="block w-full text-left text-base font-medium text-gray-900 hover:text-[hsl(129,28%,29%)]">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </nav>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
/* Remove default details marker */
details > summary {
    list-style: none;
}
details > summary::-webkit-details-marker {
    display: none;
}

/* Focus styles */
details > summary:focus {
    outline: none;
}
details > summary:focus-visible {
    outline: 2px solid hsl(129,28%,29%);
    outline-offset: 2px;
}
</style>

<script>
// Close details when clicking outside
document.addEventListener('click', (e) => {
    const details = document.querySelectorAll('details[open]');
    details.forEach(detail => {
        if (!detail.contains(e.target)) {
            detail.removeAttribute('open');
        }
    });
});

// Close details after HTMX navigation
document.body.addEventListener('htmx:afterSwap', () => {
    document.querySelectorAll('details[open]').forEach(detail => {
        detail.removeAttribute('open');
    });
});
</script>
