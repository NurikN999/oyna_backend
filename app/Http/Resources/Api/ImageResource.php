<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @OA\Schema(
     * schema="ImageResource",
     * required={"id", "path", "imageable_type", "imageable_id"},
     * @OA\Property(
     * property="id",
     * type="integer",
     * example="1"
     * ),
     * @OA\Property(
     * property="path",
     * type="string",
     * example="images/1.jpg"
     * ),
     * @OA\Property(
     * property="imageable_type",
     * type="string",
     * example="App\Models\Entertainment"
     * ),
     * @OA\Property(
     * property="imageable_id",
     * type="integer",
     * example="1"
     * )
     * )
     *
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'imageable_type' => $this->imageable_type,
            'imageable_id' => $this->imageable_id,
        ];
    }
}
