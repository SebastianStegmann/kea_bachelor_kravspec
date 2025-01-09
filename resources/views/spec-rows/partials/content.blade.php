        <div class="overflow-hidden border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Priority</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($rows as $identifier => $rowData)
                    @php
                        $row = isset($rowData['row']) ? $rowData['row'] : $rowData;
                        $previousVersion = $rowData['previousVersion'] ?? null;
                        $changeType = $rowData['changeType'] ?? null;
                        $bgColor = match($changeType) {
                            'addition' => 'bg-green-50 hover:bg-green-100',
                            'modification' => 'bg-yellow-50 hover:bg-yellow-100',
                            'deletion' => 'bg-red-50 hover:bg-red-100',
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
                        @if($changeType === 'modification')
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-yellow-400"></div>
                        @endif

                        <td class="px-4 py-3 text-sm text-gray-500">
                            <div class="flex items-center gap-2">
                                @if($changeType)
                                <span class="w-4 h-4 rounded-full flex items-center justify-center text-xs
                                           {{ $changeType === 'addition' ? 'bg-green-100 text-green-700' :
                                              ($changeType === 'modification' ? 'bg-yellow-100 text-yellow-700' :
                                               'bg-red-100 text-red-700') }}">
                                    {{ $changeType === 'addition' ? '+' :
                                       ($changeType === 'modification' ? '~' :
                                        '-') }}
                                </span>
                                @endif
                                @if($previousVersion)
                                <span class="text-xs text-gray-400">New</span>
                                @endif
                                {{$loop->iteration}}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{$row->content}}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{$row->priority}}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            <!-- Actions remain unchanged -->
                            <div class="flex gap-2">
                                <button class="edit-button text-[hsl(129,28%,29%)] hover:text-[hsl(129,28%,24%)] text-sm font-medium">
                                    Edit
                                </button>
                                <form hx-delete="/spec-rows/{{$row->id}}"
                                      hx-confirm="Are you sure you want to delete this row?"
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
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-sm text-gray-500 text-center">No rows yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
