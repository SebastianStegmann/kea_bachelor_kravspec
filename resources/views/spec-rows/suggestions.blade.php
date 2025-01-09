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
            <span class="font-medium">Suggestions</span>
        </x-breadcrumb-base>

    <!-- Compact Title + Actions -->
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-900">Suggestions for {{$spec->name}}</h1>
        <div class="flex items-center gap-3">
            <a href="#"
               class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition"
               hx-get="/{{$spec->id}}"
               hx-target="#specs-container"
               hx-swap="outerHTML"
               hx-push-url="true">
                Back to specification
            </a>
            <a href="#"
               class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition"
               hx-get="/{{$spec->id}}/settings"
               hx-swap="outerHTML"
               hx-target="#specs-container"
               hx-push-url="true">
                Settings
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="space-y-6">
        <!-- Table -->
        <div class="overflow-hidden border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Priority</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($rows as $row)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-500">{{$loop->iteration}}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{$row->content}}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{$row->priority}}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            <div class="flex items-center gap-2">
                                <button class="edit-button text-[hsl(129,28%,29%)] hover:text-[hsl(129,28%,24%)] text-sm font-medium">
                                    Edit
                                </button>
                                <form hx-post="/spec-rows/{{$row->id}}/accept"
                                      hx-confirm="Are you sure you want to accept this suggestion?"
                                      hx-swap="outerHTML"
                                      hx-target="#specs-container">
                                    @csrf
                                    <button type="submit"
                                            class="text-[hsl(129,28%,29%)] hover:text-[hsl(129,28%,24%)] text-sm font-medium">
                                        Accept
                                    </button>
                                </form>
                                <form hx-delete="/spec-rows/{{$row->id}}"
                                      hx-confirm="Are you sure you want to delete this suggestion?"
                                      hx-swap="outerHTML"
                                      hx-target="#specs-container">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <tr class="hidden bg-gray-50">
                        <td colspan="4" class="px-4 py-3">
                            <form hx-patch="/spec-rows/{{$row->id}}"
                                  hx-swap="outerHTML"
                                  hx-target="#specs-container"
                                  class="flex gap-4 items-center">
                                @csrf
                                @method('PATCH')
                                <span class="text-sm text-gray-500">{{$loop->iteration}}</span>
                                <input type="text"
                                       value="{{$row->content}}"
                                       name="content"
                                       class="flex-1 rounded border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] text-sm px-3 py-1.5">
                                <input type="text"
                                       value="{{$row->priority}}"
                                       name="priority"
                                       class="w-24 rounded border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] text-sm px-3 py-1.5">
                                <input type="hidden" name="spec_id" value="{{$spec->pivot->spec_id}}">
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent rounded text-sm font-medium text-white bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition">
                                    Save
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-sm text-gray-500 text-center">No suggestions yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add New Suggestion Form -->
        <form hx-post="/spec-rows"
              hx-swap="outerHTML"
              hx-target="#specs-container"
              class="flex gap-4 items-center">
            @csrf
            <input type="text"
                   name="content"
                   placeholder="Content"
                   required
                   class="flex-1 rounded border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] text-sm px-3 py-1.5">
            <input type="text"
                   name="priority"
                   placeholder="Priority"
                   required
                   class="w-24 rounded border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] text-sm px-3 py-1.5">
            <input type="hidden" name="version" value="1">
            <input type="hidden" name="spec_id" value="{{$spec->pivot->spec_id}}">
            <button type="submit"
                    class="inline-flex items-center px-3 py-1.5 border border-transparent rounded text-sm font-medium text-white bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition">
                Add Suggestion
            </button>
        </form>
    </div>
</div>

<script>
    document.body.addEventListener('htmx:load', function(event) {
        initializeEditButtons(event.detail.elt);
    });

    function initializeEditButtons(container) {
        container.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                let currentRow = this.closest('tr');
                let editRow = currentRow.nextElementSibling;

                // Hide any other open edit rows
                container.querySelectorAll('tr').forEach(row => {
                    if (row !== editRow && row.classList.contains('bg-gray-50')) {
                        row.previousElementSibling.style.display = '';
                        row.style.display = 'none';
                    }
                });

                currentRow.style.display = 'none';
                editRow.style.display = 'table-row';
            });
        });
    }
</script>
