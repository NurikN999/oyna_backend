<?php

declare(strict_types=1);

namespace App\Services\Api;

use Illuminate\Support\Facades\Storage;

class MusicService
{
    public function upload($file, string $title)
    {
        $fileName = $title . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/audio', $fileName);

        return $path;
    }

    public function delete($path)
    {
        if (file_exists(storage_path('app/' . $path))) {
            unlink(storage_path('app/' . $path));
        }
    }

}
