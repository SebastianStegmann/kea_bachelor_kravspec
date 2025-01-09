<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name"
                         class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] focus:border-transparent transition mt-1"
                         type="text"
                         name="name"
                         :value="old('name')"
                         required
                         autofocus
                         autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                         class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] focus:border-transparent transition mt-1"
                         type="email"
                         name="email"
                         :value="old('email')"
                         required
                         autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password"
                          class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] focus:border-transparent transition mt-1"
                          type="password"
                          name="password"
                          required
                          autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Password Requirements -->
            <ul class="mt-2 text-sm text-gray-600 space-y-1">
                <li class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    At least 8 characters long
                </li>
            </ul>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation"
                         class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] focus:border-transparent transition mt-1"
                         type="password"
                         name="password_confirmation"
                         required
                         autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)]"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
