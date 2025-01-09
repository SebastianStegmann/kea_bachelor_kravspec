<button {{ $attributes->merge(['type' => 'button', 'class' => 'px-4 py-3 bg-white border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition']) }}>
    {{ $slot }}
</button>
