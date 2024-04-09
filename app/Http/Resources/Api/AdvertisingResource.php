<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AdvertisingResource",
 *     type="object",
 *     title="AdvertisingResource",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="title", type="string", example="Advertising title"),
 *     @OA\Property(property="placement_area", type="string", example="Placement area"),
 *     @OA\Property(property="play_time", type="integer", example="30"),
 *     @OA\Property(property="description", type="string", example="Advertising description"),
 *     @OA\Property(property="video_path", type="string", example="http://oynapp.kz/storage/videos/1.mp4"),
 * )
 */
class AdvertisingResource extends JsonResource
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
            'placement_area' => $this->placement_area,
            'play_time' => $this->play_time,
            'description' => $this->description,
            'video_path' => $this->video_path,
        ];
    }
}
