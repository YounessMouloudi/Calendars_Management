<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.config', 'Gestion Calendriers') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    </head>
    <body class="bg-body">
        <div class="container py-5">
            <main class="py-5 text-center">
                <h1>App Gestion Calendriers</h1>
                @if (Route::has('login'))
                    <div class="py-5">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary ps-4 pe-4 mb-1 me-2 rounded-pill">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary ps-4 pe-4 mb-1 me-2 rounded-pill">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary ps-4 pe-4 mb-1 me-2 rounded-pill">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </main>
        </div>
    </body>
</html>
