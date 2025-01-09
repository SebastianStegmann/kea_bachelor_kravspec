<div class="overflow-hidden border border-gray-200 rounded-lg">
    <table class="min-w-full divide-y divide-gray-200" role="table">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Priority</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @php
                // Sort rows by row_identifier to maintain consistent positioning
                $sortedRows = collect($rows)->sortBy(function($rowData) {
                    return is_array($rowData) ? $rowData['row']->row_identifier : $rowData->row_identifier;
                });
            @endphp

            @forelse ($sortedRows as $identifier => $rowData)
            @php
                $row = isset($rowData['row']) ? $rowData['row'] : $rowData;
                $previousVersion = $rowData['previousVersion'] ?? null;
                $changeType = $rowData['changeType'] ?? null;
                $bgColor = match($changeType) {
                    'addition' => 'bg-green-50 hover:bg-green-100',
                    'modification' => 'bg-yellow-50 hover:bg-yellow-100',
                    'deletion' => 'bg-red-50',
                    default => 'hover:bg-gray-50'
                };
            @endphp

            @if($previousVersion && $changeType === 'modification')
            <tr class="bg-gray-50 border-t border-gray-200">
                <td class="px-4 py-3 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400">Previous</span>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm text-gray-500">{{$previousVersion->content}}</td>
                <td class="px-4 py-3 text-sm text-gray-500">{{$previousVersion->priority}}</td>
                <td class="px-4 py-3 text-sm text-gray-500"></td>
            </tr>
            @endif

            <tr class="{{$bgColor}} transition-colors group relative">
                @if($changeType === 'deletion')
                <td colspan="4" class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full flex items-center justify-center text-xs bg-red-100 text-red-700">
                            -
                        </span>
                        <span class="text-sm text-red-700">Row #{{$row->row_identifier}} was deleted</span>
                    </div>
                </td>
                @else
                <td class="px-4 py-3 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        @if($changeType)
                        <span class="w-4 h-4 rounded-full flex items-center justify-center text-xs
                                   {{ $changeType === 'addition' ? 'bg-green-100 text-green-700' :
                                      ($changeType === 'modification' ? 'bg-yellow-100 text-yellow-700' :
                                       'bg-red-100 text-red-700') }}"
                              aria-hidden="true">
                            {{ $changeType === 'addition' ? '+' :
                               ($changeType === 'modification' ? '~' :
                                '-') }}
                        </span>
                        @endif
                        {{$row->row_identifier}}
                    </div>
                </td>
                <td class="px-4 py-3 text-sm text-gray-900">{{$row->content}}</td>
                <td class="px-4 py-3 text-sm text-gray-900">{{$row->priority}}</td>
                <td class="px-4 py-3 text-sm text-gray-500">
                    @if(!$changeType || $changeType !== 'deletion')
                    <div class="flex gap-2">
                        <button type="button"
                                class="edit-button text-[hsl(129,28%,29%)] hover:text-[hsl(129,28%,24%)] text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:ring-offset-2 rounded"
                                tabindex="0">
                            Edit
                        </button>
                        <form hx-delete="/spec-rows/{{$row->id}}"
                              hx-confirm="Are you sure you want to delete this row?"
                              hx-swap="outerHTML"
                              hx-target="#specs-container">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:text-red-900 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 rounded"
                                    tabindex="0">
                                Delete
                            </button>
                        </form>
                    </div>
                    @endif
                </td>
                @endif
            </tr>

            @if(!$changeType || $changeType !== 'deletion')
            <tr class="hidden bg-gray-50">
                <td colspan="4" class="px-4 py-3">
                    @if($spec->status == 1)
                    <form hx-post="/spec-rows"
                          hx-swap="outerHTML"
                          hx-target="#specs-container"
                          class="flex gap-4 items-center">
                    @else
                    <form hx-patch="/spec-rows/{{$row->id}}"
                          hx-swap="outerHTML"
                          hx-target="#specs-container"
                          class="flex gap-4 items-center">
 @method('PATCH')
                    @endif
                        @csrf
                        <span class="text-sm text-gray-500">{{$row->row_identifier}}</span>
                        <input type="text"
                               value="{{$row->content}}"
                               name="content"
                               class="flex-1 rounded border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] text-sm px-3 py-1.5"
                               tabindex="0">
                        <input type="text"
                               value="{{$row->priority}}"
                               name="priority"
                               class="w-24 rounded border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] text-sm px-3 py-1.5"
                               tabindex="0">
                        <input type="hidden" name="row_identifier" value="{{$row->row_identifier}}">
                        <input type="hidden" name="spec_id" value="{{$spec->id}}">
                        <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent rounded text-sm font-medium text-white bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition"
                                tabindex="0">
                            Save
                        </button>
                    </form>
                </td>
            </tr>
            @endif
            @empty
            <tr>
                <td colspan="4" class="px-4 py-3 text-sm text-gray-500 text-center">No rows yet</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Add New Row Form -->
    @if ($spec['status'] == 0)
    <div class="p-4 border-t border-gray-200">
        <form hx-post="/spec-rows"
              hx-swap="outerHTML"
              hx-target="#specs-container"
              class="flex gap-4 items-center">
            @csrf
            <input type="text"
                   name="content"
                   placeholder="Content"
                   required
                   class="flex-1 rounded border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] text-sm px-3 py-1.5"
                   tabindex="0">
            <input type="text"
                   name="priority"
                   placeholder="Priority"
                   required
                   class="w-24 rounded border border-gray-300 shadow-sm focus:ring-2 focus:ring-[hsl(129,28%,29%)] focus:border-[hsl(129,28%,29%)] text-sm px-3 py-1.5"
                   tabindex="0">
            <input type="hidden" name="version" value="1">
            <input type="hidden" name="spec_id" value="{{$spec->id}}">
            <button type="submit"
                    class="inline-flex items-center px-3 py-1.5 border border-transparent rounded text-sm font-medium text-white bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition"
                    tabindex="0">
                Add Row
            </button>
        </form>
    </div>
    @endif
</div>
<script>
// Wait for the DOM to be ready
document.addEventListener('DOMContentLoaded', initializeEditButtons);

// Also listen for HTMX content updates
document.addEventListener('htmx:afterSwap', initializeEditButtons);

function initializeEditButtons() {
    // Find all edit buttons
    const editButtons = document.querySelectorAll('.edit-button');

    editButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            // Get the main row that contains the button
            const mainRow = button.closest('tr');

            // Get the edit form row (it's the next row with class bg-gray-50)
            const editRow = mainRow.nextElementSibling;

            // First hide all other edit forms
            document.querySelectorAll('tr.bg-gray-50').forEach(row => {
                row.style.display = 'none';
                // Show the corresponding main row
                if (row.previousElementSibling) {
                    row.previousElementSibling.style.display = '';
                }
            });

            // Toggle the clicked row
            mainRow.style.display = 'none';
            editRow.style.display = 'table-row';

            // Focus the first input in the edit form
            const firstInput = editRow.querySelector('input[type="text"]');
            if (firstInput) {
                firstInput.focus();
            }
        });
    });
}
</script>
