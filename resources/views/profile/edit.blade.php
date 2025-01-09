<div id="specs-container" class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="#"
           class="hover:text-gray-700 flex items-center"
           hx-get="/"
           hx-target="#specs-container"
           hx-swap="outerHTML"
           hx-push-url="true">
            <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            All specifications
        </a>
        <span>/</span>
        <span>Profile Settings</span>
    </nav>

    <!-- Profile Sections -->
    <div class="space-y-6">
        <!-- Profile Information -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
