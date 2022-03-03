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

<body class="flex flex-row min-h-screen bg-gray-100 text-gray-800">
    <x-sidebar />

    <main id="app" class="main flex flex-col flex-grow -ml-64 md:ml-0">
        <x-header />
        <div class="container pt-4">@yield('content')</div>
    </main>

    <!-- Vite -->
    {{ vite_assets() }}
</body>

</html>
