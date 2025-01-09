<div id="specs-container" class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Subtle Breadcrumb -->
    <x-breadcrumb-base>
        <span aria-hidden="true">/</span>
            <a href="#"
               class="hover:text-gray-700"
               hx-get="/{{$spec->id}}"
               hx-target="#specs-container"
               hx-swap="outerHTML"
               hx-push-url="true"
               tabindex="0"
               role="link">
                {{$spec->name}}
            </a>
            <span aria-hidden="true">/</span>
            <span class="font-medium">Settings</span>
        </x-breadcrumb-base>

    <!-- Compact Title -->
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-900">Specification Settings</h1>
    </div>

    <!-- Rest of the settings content -->
    <div class="space-y-8">

        <form hx-patch="/{{$spec->id}}/settings"
              hx-target="#specs-container"
              hx-swap="outerHTML"
              hx-confirm="Are you sure you want to update these settings?"
              class="space-y-8">
            @csrf
            <input type="hidden" name="id" value="{{$spec->id}}">

            <div class="space-y-2">
                <label for="name" class="block text-base font-medium text-gray-700">
                    Specification Name
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{$spec->name}}"
                       required
                       class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] focus:border-transparent transition">
                <p class="text-sm text-gray-500 mt-1">
                    The name should clearly identify the purpose of this specification.
                </p>
            </div>

            <div class="space-y-2">
                <label for="status" class="block text-base font-medium text-gray-700">
                    Status
                </label>
                @if($spec->status === 0)
                <select id="status"
                        name="status"
                        required
                        class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] transition appearance-none bg-white">
                    <option value="Yes" {{$spec->status == 1 ? 'selected' : ''}}>Activated</option>
                    <option value="No" {{$spec->status == 0 ? 'selected' : ''}}>Draft</option>
                </select>
                @else
                <p class="text-base text-gray-900">Activated</p>
                @endif
                <p class="text-sm text-gray-500 mt-1">
                    Once activated, change history will be tracked and the specification becomes read-only.
                </p>
            </div>

            <button type="submit"
                    class="w-full py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition">
                Save Changes
            </button>
        </form>
    </div>

    <hr class="border-gray-200">

    <!-- Current Participants Section -->
    <div class="space-y-8">
        <h2 class="text-2xl font-semibold text-gray-900">Current Participants</h2>

        @if(count($users) > 0)
        <ul class="space-y-6">
            @foreach($users as $user)
            <li class="flex items-center justify-between pb-6 @if(!$loop->last) border-b border-gray-200 @endif">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{$user->name}}</h3>
                    <p class="text-base text-gray-500">{{$user->email}}</p>
                    <p class="text-base text-gray-500">
                        Role: {{ match($user->pivot->role_id) {
                            1 => 'Administrator',
                            2 => 'Editor',
                            3 => 'Viewer',
                            default => 'Unknown'
                        } }}
                    </p>
                </div>
                @if ($user->pivot->role_id !== 1)
                <form hx-delete="/{{$spec->id}}/settings"
                      hx-swap="innerHTML"
                      hx-target="#participant-error"
                      hx-confirm="Are you sure you want to remove {{$user->name}}?">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition">
                        Remove
                    </button>
                </form>
                @endif
            </li>
            @endforeach
        </ul>
        <div id="participant-error" class="mt-4 text-red-600"></div>
        @else
        <p class="text-base text-gray-500">No participants have been added yet.</p>
        @endif
    </div>

    <hr class="border-gray-200">

    <!-- Add Participant Section -->
    <div class="space-y-8">
        <h2 class="text-2xl font-semibold text-gray-900">Add New Participant</h2>

        <form hx-post="/{{$spec->id}}/settings"
              hx-target="#add-participant-error"
              hx-swap="innerHTML"
              class="space-y-8">
            @csrf
            <div class="space-y-2">
                <label for="participant-email" class="block text-base font-medium text-gray-700">
                    Email Address
                </label>
                <input type="email"
                       id="participant-email"
                       name="email"
                       required
                       placeholder="colleague@example.com"
                       class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] transition">
                <p class="text-sm text-gray-500 mt-1">
                    Enter the email address of the person you want to add.
                </p>
            </div>

            <div class="space-y-2 relative">
                <label for="participant-role" class="block text-base font-medium text-gray-700">
                    Role
                </label>
                <select id="participant-role"
                        name="role"
                        required
                        class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] transition appearance-none bg-white">
                    <option value="2">Editor</option>
                    <option value="3">Viewer</option>
                </select>
                <!-- Custom arrow for select -->
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700" style="top: 2.5rem">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    Editors can make changes, viewers can only read.
                </p>
            </div>

            <button type="submit"
                    class="w-full py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition">
                Add Participant
            </button>
        </form>
        <div id="add-participant-error" class="mt-4 text-red-600"></div>
    </div>

    <hr class="border-gray-200">

    <!-- Danger Zone -->
    <div class="space-y-8">
        <h2 class="text-2xl font-semibold text-red-600">Danger Zone</h2>

        <div class="space-y-4">
            <p class="text-base text-gray-900">
                Once you delete a specification, there is no going back. Please be certain.
            </p>

            <button class="inline-flex items-center px-6 py-3 border border-red-600 rounded-lg text-base font-medium text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition"
                    hx-delete="/{{ $spec->id }}"
                    hx-confirm="Are you sure you want to permanently delete this specification?"
                    hx-target="#specs-container"
                    hx-swap="outerHTML"
                    hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'">
                Delete Specification
            </button>
        </div>
    </div>
</div>
