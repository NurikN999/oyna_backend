<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Image;
use App\Services\S3\S3Service;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    private $s3Service;

    public function __construct(S3Service $s3Service)
    {
        $this->s3Service = $s3Service;
    }

    public function upload($file, string $imageableType, int $imageableId)
    {
        $fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
        $path = 'images/' . $fileName;

        $link = $this->s3Service->uploadFileToS3($file, $path);
        list($width, $height) = getimagesize($file);

        $image = Image::create([
            'path' => $link,
            'imageable_type' => $imageableType,
            'imageable_id' => $imageableId,
            'width' => $width,
            'height' => $height,
        ]);

        return $image;
    }

    public function update($file, string $imageableType, int $imageableId)
    {
        $fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
        $path = 'images/' . $fileName;

        $link = $this->s3Service->uploadFileToS3($file, $path);
        list($width, $height) = getimagesize($file);

        $image = Image::where('imageable_type', $imageableType)->where('imageable_id', $imageableId)->first();
        $image->update([
            'path' => $link,
            'width' => $width,
            'height' => $height,
        ]);

        return $image;

    }

    public function delete(Image $image)
    {
        $this->s3Service->deleteFileFromS3($image->path);
        $image->delete();
    }

}
