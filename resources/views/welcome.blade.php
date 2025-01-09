<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- HTMX -->
    <script src="https://unpkg.com/htmx.org@2.0.3" defer></script>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="">
    <div class="">
        <div class="">
            <div class="">
                <header class="">
                    <div class="">
                    </div>
                    @if (Route::has('login'))
                    <nav class="">
                        @auth
                        <a href="#" hx-get="{{env('APP_URL')}}" hx-target="#specs-container" hx-swap="outerHTML" class="">
                            Dashboard
                        </a>
                        <a href="{{env('APP_URL')}}"> go to specs </a>

                        @else
                        <a href="{{ route('login') }}" class="">
                            Log in
                        </a>

                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="">
                            Register
                        </a>
                        @endif
                        @endauth
                    </nav>
                    @endif
                </header>

                <main class="mt-6">
                </main>

            </div>
        </div>
    </div>
</body>

</html>
