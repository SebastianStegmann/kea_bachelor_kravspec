<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-3 bg-[hsl(129,28%,29%)] border border-transparent rounded-lg font-medium text-white hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition', 'tabindex' => '0']) }}>
    {{ $slot }}
</button>
