<button {{ $attributes->merge(['type' => 'button', 'class' => 'px-4 py-3 bg-red-600 border border-transparent rounded-lg font-medium text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition', 'tabindex' => '0']) }}>
    {{ $slot }}
</button>
