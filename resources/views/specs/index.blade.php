<div id="specs-container" class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">All Specifications</h1>
        <a href="/new"
           hx-get="/new"
           hx-target="#specs-container"
           hx-swap="outerHTML"
           hx-push-url="true"
           tabindex="0"
           role="link"
           class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition">
            New Specification
        </a>
    </div>

    @if(count($specs) > 0)
    <ul class="divide-y divide-gray-200" role="list">
        @foreach ($specs as $spec)
        <li class="py-3">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <a href="/{{$spec->id}}"
                       class="group flex items-center gap-3"
                       hx-get="/{{$spec->id}}"
                       hx-trigger="click"
                       hx-target="#specs-container"
                       hx-swap="outerHTML"
                       hx-push-url="true"
                       tabindex="0"
                       role="link">
                        <h2 class="text-base font-medium text-gray-900 group-hover:text-[hsl(129,28%,29%)] transition">
                            {{$spec->name}}
                        </h2>
                        <span class="text-sm text-gray-500">
                            {{ $spec->status ? 'Activated' : 'Draft' }}
                        </span>
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <a href="/{{$spec->id}}/suggestions"
                       class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 rounded text-xs font-medium {{ $spec->status ? 'text-gray-700 bg-white hover:bg-gray-50' : 'text-gray-400 bg-gray-50 cursor-not-allowed' }}"
                       @if($spec->status)
                       hx-get="/{{$spec->id}}/suggestions"
                       hx-trigger="click"
                       hx-target="#specs-container"
                       hx-swap="outerHTML"
                       hx-push-url="true"
                       tabindex="0"
                       role="link"
                       @else
                       tabindex="-1"
                       aria-disabled="true"
                       @endif>
                        Suggestions
                    </a>
                    <a href="/{{$spec->id}}/settings"
                       class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 rounded text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition"
                       hx-get="/{{$spec->id}}/settings"
                       hx-trigger="click"
                       hx-target="#specs-container"
                       hx-swap="outerHTML"
                       hx-push-url="true"
                       tabindex="0"
                       role="link">
                        Settings
                    </a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    @else
    <div class="text-center py-8">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No specifications yet</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by creating a new specification.</p>
        <div class="mt-6">
            <a href="/new"
               class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[hsl(129,28%,29%)] hover:bg-[hsl(129,28%,24%)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition"
               hx-get="/new"
               hx-target="#specs-container"
               hx-swap="outerHTML"
               hx-push-url="true"
               tabindex="0"
               role="link">
                <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                New Specification
            </a>
        </div>
    </div>
    @endif
</div>
