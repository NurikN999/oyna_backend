<?php

declare(strict_types=1);

namespace App\Services\S3;

use Illuminate\Support\Facades\Storage;

class S3Service
{
    public function uploadFileToS3($file, string $path): string
    {
        $disk = Storage::disk('ps');

        $disk->put($path, file_get_contents($file->getRealPath()), 'public');

        return $disk->url($path);
    }

    public function deleteFileFromS3(string $path): void
    {
        $disk = Storage::disk('ps');

        $disk->delete($path);
    }
}
