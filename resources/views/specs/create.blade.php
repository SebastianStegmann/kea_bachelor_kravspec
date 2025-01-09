<div id="specs-container" class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Subtle Breadcrumb -->

        <x-breadcrumb-base>
        <span>/</span>
        <span>New specification</span>
        </x-breadcrumb-base>


    <!-- Compact Title -->
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-900">Create new specification</h1>
    </div>

    <!-- Form content -->
    <div class="space-y-6">
        <form hx-post="/new"
              hx-target="#specs-container"
              hx-trigger="submit"
              hx-swap="outerHTML"
              class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="spec-name" class="block text-base font-medium text-gray-700">
                    Specification Name
                </label>
                <input type="text"
                       id="spec-name"
                       name="spec-name"
                       autocomplete="off"
                       required
                       placeholder="Enter specification name"
                       class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] transition">
                <p class="text-sm text-gray-500 mt-1">
                    The name should clearly identify the purpose of this specification.
                </p>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="w-full py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition">
                    Create Specification
                </button>
            </div>
        </form>
    </div>
</div>
