<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="MusicResource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the music"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the music"
 *     ),
 *     @OA\Property(
 *         property="genre",
 *         type="string",
 *         description="The genre of the music"
 *     ),
 *     @OA\Property(
 *         property="path",
 *         type="string",
 *         description="The URL of the music file"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="string",
 *         description="The image of the music"
 *     ),
 * )
 */
class MusicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'genre' => $this->genre,
            'path' => Storage::url($this->path),
            'image' => $this->image,
        ];
    }
}
