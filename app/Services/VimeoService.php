<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VimeoService
{

    public function getHlsLink($videoId)
    {
        $accessToken = "833654efae12ebaf0c7cb57297761705";
        $response = Http::withToken($accessToken)->get("https://api.vimeo.com/videos/{$videoId}");
        // dd($response);

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
