<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

function vite_assets(): HtmlString
{
    $devServerIsRunning = false;
    $hostIP = config('dev.host_ip');
    $vitePort = config('dev.vite_port');
    $baseURL = config('app.base_url');

    if (strlen($baseURL) > 0) {
        $baseURL = "/{$baseURL}";
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
        <script type="module" src="{$baseURL}/build/{$manifest['resources/scripts/main.ts']['file']}"></script>
        <link rel="stylesheet" href="{$baseURL}/build/{$manifest['resources/scripts/main.ts']['css'][0]}">
    HTML);
}
