<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Image;

class ImageService
{

    public function upload($file, string $imageableType, int $imageableId)
    {
        $path = $file->store('images', 'public');
        $image = Image::create([
            'path' => $path,
            'imageable_type' => $imageableType,
            'imageable_id' => $imageableId
        ]);

        return $image;
    }

}
