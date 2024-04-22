<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Services\S3\S3Service;

class VideoService
{
    private $s3Service;

    public function __construct(S3Service $s3Service)
    {
        $this->s3Service = $s3Service;
    }

    public function upload($file)
    {
        $fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
        $videoPath = 'videos/' . $fileName;

        $link = $this->s3Service->uploadFileToS3($file, $videoPath);

        return $link;
    }
}
