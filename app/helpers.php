<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

function vite_assets(): HtmlString
{
    $devServerIsRunning = false;
    $hostIP = env('HOST_IP', 'localhost');
    $vitePort = env('VITE_PORT', '3000');
    $subURL = env('APP_SUBURL', '');

    if (strlen($subURL) > 0) {
        $subURL = "/{$subURL}";
    }

    if (app()->environment('local')) {
        Http::get("http://{$hostIP}:{$vitePort}");
        $devServerIsRunning = true;
    }

    if ($devServerIsRunning) {
        return new HtmlString(<<<HTML
            <script type="module" src="http://{$hostIP}:{$vitePort}/@vite/client"></script>
            <script type="module" src="http://{$hostIP}:{$vitePort}/resources/scripts/main.ts"></script>
        HTML);
    }

    $manifest = json_decode(file_get_contents(
        public_path('build/manifest.json')
    ), true);

    return new HtmlString(<<<HTML
        <script type="module" src="{$subURL}/build/{$manifest['resources/scripts/main.ts']['file']}"></script>
        <link rel="stylesheet" href="{$subURL}/build/{$manifest['resources/scripts/main.ts']['css'][0]}">
    HTML);
}
