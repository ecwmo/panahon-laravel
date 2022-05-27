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

@php
$subURL = config('misc.suburl');
if ($subURL != '') {
    $subURL = "/{$subURL}/";
} else {
    $subURL = '/';
}
@endphp

<body class="font-sans leading-none text-gray-700 bg-gray-100 antialiased">
    <div id="app">
    </div>

    <!-- Vite -->
    {{ vite_assets() }}
</body>

</html>
