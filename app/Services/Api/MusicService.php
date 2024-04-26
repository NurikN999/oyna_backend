<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Music;
use App\Services\S3\S3Service;
use Illuminate\Support\Facades\Storage;

class MusicService
{
    private $s3Service;

    public function __construct(S3Service $s3Service)
    {
        $this->s3Service = $s3Service;
    }

    public function upload($file, string $title)
    {
        $fileName = $title . '.' . $file->getClientOriginalExtension();
        $path = 'musics/' . $fileName;

        $link = $this->s3Service->uploadFileToS3($file, $path);

        return $link;
    }

    public function delete($path)
    {
        if (file_exists(storage_path('app/' . $path))) {
            unlink(storage_path('app/' . $path));
        }
    }

}
