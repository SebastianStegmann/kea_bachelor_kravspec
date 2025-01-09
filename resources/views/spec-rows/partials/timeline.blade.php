<ul class="space-y-2">
    <!-- Current Version -->
    <li class="timeline-item relative group">
        <a hx-get="/{{$spec->id}}/table"
           hx-trigger="click"
           hx-target="#table-content"
           class="text-sm flex items-center gap-2 {{ !$time ? 'font-semibold' : 'text-gray-500' }}">
            <span class="w-5 h-5 rounded-full flex items-center justify-center {{ !$time ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                </svg>
            </span>
            Latest Version
            @if(!$time)
                <span class="ml-2 px-2 py-0.5 text-xs bg-emerald-100 text-emerald-700 rounded-full">Current</span>
            @endif
        </a>
    </li>

    @php
        $groupedChanges = collect($timeline)->groupBy(function($change) {
            return date('Y-m-d', $change['time']);
        });
    @endphp

    @foreach($groupedChanges as $day => $changes)
        <li class="timeline-group">
            <button type="button"
                    class="w-full py-2 relative group flex items-center text-sm text-gray-500 hover:text-gray-700"
                    onclick="toggleTimelineGroup('{{ $day }}')">
                <span class="w-5 h-5 rounded-full flex items-center justify-center border-2 border-gray-300 mr-2">
                    <svg class="w-3 h-3 transform transition-transform timeline-group-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
                {{ date('F j, Y', strtotime($day)) }}
                <span class="ml-2 text-xs text-gray-400">({{ count($changes) }} {{ Str::plural('change', count($changes)) }})</span>
            </button>
            <ul class="timeline-group-content hidden space-y-2">
                @foreach($changes as $change)
                    <li class="timeline-item relative group {{ (string)$time === (string)$change['time'] ? 'bg-blue-50' : '' }}">
                        <a hx-get="/{{$spec->id}}/table/{{$change['time']}}"
                           hx-trigger="click"
                           hx-target="#table-content"
                           class="py-2 pl-6 text-sm flex items-center gap-2 w-full
                                  {{ $change['type'] === 'addition' ? 'text-green-600' :
                                     ($change['type'] === 'modification' ? 'text-yellow-600' :
                                      'text-red-600') }}">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs
                                       {{ $change['type'] === 'addition' ? 'bg-green-100' :
                                          ($change['type'] === 'modification' ? 'bg-yellow-100' :
                                           'bg-red-100') }}">
                                {{ $change['type'] === 'addition' ? '+' :
                                   ($change['type'] === 'modification' ? '~' :
                                    '-') }}
                            </span>
                            <span>{{date('H:i:s', $change['time'])}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>

<script>
function toggleTimelineGroup(groupId) {
    const button = event.currentTarget;
    const content = button.nextElementSibling;
    const icon = button.querySelector('.timeline-group-icon');

    content.classList.toggle('hidden');
    icon.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(90deg)';
}

// Automatically expand the group containing the currently viewed time
document.addEventListener('DOMContentLoaded', function() {
    const currentTime = '{{ $time }}';
    if (currentTime) {
        const activeItem = document.querySelector(`[hx-get$="${currentTime}"]`);
        if (activeItem) {
            const group = activeItem.closest('.timeline-group-content');
            if (group) {
                group.classList.remove('hidden');
                const icon = group.previousElementSibling.querySelector('.timeline-group-icon');
                icon.style.transform = 'rotate(90deg)';
            }
        }
    }
});
</script>
