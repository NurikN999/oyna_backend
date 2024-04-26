<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PrizeResource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the prize"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the prize"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the prize"
 *     ),
 *     @OA\Property(
 *         property="point_amount",
 *         type="integer",
 *         description="Point amount of the prize"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         ref="#/components/schemas/ImageResource",
 *         description="The image of the prize"
 *     )
 * )
 */
class PrizeResource extends JsonResource
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
            'description' => $this->description,
            'point_amount' => $this->point_amount,
            'image' => new ImageResource($this->image)
        ];
    }
}
