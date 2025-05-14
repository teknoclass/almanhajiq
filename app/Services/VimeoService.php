<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VimeoService
{

    public function getHlsLink($videoId)
    {
        $accessToken = env('VIMEO_ACCESS_TOKEN');
        $response = Http::withToken($accessToken)->get("https://api.vimeo.com/videos/{$videoId}");

        if (!$response->ok()) {
            return null;
        }

        $files = $response->json('files') ?? [];


        foreach ($files as $file) {
            if ($file['quality'] === 'hls') {
                return $file['link'];
            }
        }

        return null;
    }
}
