<div id="toast"
     class="bg-white border border-gray-200 shadow-lg px-4 py-3 rounded-lg flex items-center gap-2"
     hx-swap-oob="afterbegin:#toast-container"
     hx-trigger="load delay:3s"
     hx-target="this"
     hx-swap="delete">
    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    <span class="text-gray-700">{{ $message }}</span>
</div>
