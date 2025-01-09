<div id="specs-container" class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Breadcrumb -->
    <x-breadcrumb-base>
            <span aria-hidden="true">/</span>
            <span class="font-medium">{{$spec->name}}</span>
    </x-breadcrumb-base>

    <!-- Compact Title + Actions -->
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-900">{{$spec->name}}</h1>
        <div class="flex items-center gap-3">
            @if($spec->status == 1)
            <a href="/{{$spec->id}}/suggestions"
               class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition"
               hx-get="/{{$spec->id}}/suggestions"
               hx-swap="outerHTML"
               hx-target="#specs-container"
               hx-push-url="true"
               tabindex="0"
               role="link">
                View suggestions
            </a>
            @endif
            <a href="/{{$spec->id}}/settings"
               class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(129,28%,29%)] transition"
               hx-get="/{{$spec->id}}/settings"
               hx-swap="outerHTML"
               hx-target="#specs-container"
               hx-push-url="true"
               tabindex="0"
               role="link">
                Settings
            </a>
        </div>
    </div>

    <!-- Table Section -->
    <div id="table-content">
        @include('spec-rows.partials.table', [
            'spec' => $spec,
            'rows' => $rows,
            'time' => $time
        ])
    </div>

    <!-- Timeline Section -->
    @if (isset($timeline))
    <section class="pt-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-200 pb-4">Timeline of changes</h2>
        <div id="timeline-content">
            @include('spec-rows.partials.timeline', [
                'spec' => $spec,
                'timeline' => $timeline,
                'time' => $time
            ])
        </div>
    </section>
    @endif
</div>

