<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>

<body class="font-sans leading-none text-gray-700 bg-gray-100 antialiased">
    <div id="app">
        <div class="md:flex md:flex-col">
            <div class="md:h-screen md:flex md:flex-col">
                <v-header :title="'{{ config('app.name', 'Laravel') }}'" @auth
                    :username="'{{ Auth::user()->name }}'" @endauth
                    @if (Route::has('login')) :login-url="'{{ route('login') }}'" @endif
                    :logout-url="'{{ route('logout') }}'"
                    @if (Route::has('register')) :register-url="'{{ route('register') }}'" @endif
                    :is-super-admin="@json(Auth::check() && Auth::user()->hasRole('SUPERADMIN'))">
                </v-header>

                <div class="md:flex md:flex-grow md:overflow-hidden">
                    <v-sidebar :is-super-admin="@json(Auth::check() && Auth::user()->hasRole('SUPERADMIN'))"></v-sidebar>
                    <div class="md:flex-1 px-4 py-8 md:p-12 md:overflow-y-auto">@yield('content')</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vite -->
    {{ vite_assets() }}
</body>

</html>
