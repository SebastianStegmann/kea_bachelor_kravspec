<nav class="flex items-center space-x-2 text-sm text-gray-500" aria-label="Breadcrumb">
    <a href="/"
       class="hover:text-gray-700 flex items-center"
       hx-get="/"
       hx-target="#specs-container"
       hx-swap="outerHTML"
       hx-push-url="true"
       tabindex="0"
       role="link">
        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        <span>All specifications</span>
    </a>
    {{ $slot }}
</nav>
