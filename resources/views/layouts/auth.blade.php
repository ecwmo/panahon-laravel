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
    <div id="app" class="p-6 bg-blue-800 min-h-screen flex justify-center items-center">
        <div class="w-full max-w-md">
            <h1 class="text-center font-bold text-gray-200 text-4xl">Panahon</h1>
            <div class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden">@yield('content')</div>
        </div>
    </div>

    <!-- Vite -->
    {{ vite_assets() }}
</body>

</html>
