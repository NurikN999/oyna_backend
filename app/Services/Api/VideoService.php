<?php

declare(strict_types=1);

namespace App\Services\Api;

class VideoService
{
    public function upload($file)
    {
        $path = $file->store('videos', 'public');
        $videoPath = 'http://oynapp.kz/storage/' . $path;

        return $videoPath;
    }
}
