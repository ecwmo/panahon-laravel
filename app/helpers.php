<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

function vite_assets(): HtmlString
{
    $devServerIsRunning = false;
    $hostIP = env('HOST_IP', 'localhost');
    $vitePort = env('VITE_PORT', '3000');

    if (app()->environment('local')) {
        Http::get("http://{$hostIP}:{$vitePort}");
        $devServerIsRunning = true;
    }

    if ($devServerIsRunning) {
        return new HtmlString(<<<HTML
            <script type="module" src="http://{$hostIP}:{$vitePort}/@vite/client"></script>
            <script type="module" src="http://{$hostIP}:{$vitePort}/resources/js/app.js"></script>
        HTML);
    }

    $manifest = json_decode(file_get_contents(
        public_path('build/manifest.json')
    ), true);

    return new HtmlString(<<<HTML
        <script type="module" src="/build/{$manifest['resources/js/app.js']['file']}"></script>
        <link rel="stylesheet" href="/build/{$manifest['resources/js/app.js']['css'][0]}">
    HTML);
}
