<div id="{{ $id ?? 'modal' }}"
     class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 hidden"
     role="dialog"
     aria-modal="true"
     aria-labelledby="modal-title">

    <div class="flex items-center justify-center min-h-screen">
        <!-- Backdrop -->
        <div class="fixed inset-0 transform">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-lg overflow-hidden shadow-xl sm:w-full sm:max-w-lg relative">
            {{ $slot }}
        </div>
    </div>
</div>
