<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>


                <!-- <div id="specs-container" hx-get="/specs" hx-trigger="load" hx-swap="outerHTML"> -->
                <!--     <p>Loading specs...</p> -->
                <!---->
                <!-- </div> -->
                @isset($content)
                {!! $content !!}
                @else
                <!-- Default content or loading message -->
                <div>Loading...</div>
                @endisset


</x-app-layout>
