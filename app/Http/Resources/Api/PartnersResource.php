<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PartnersResource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the partner"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the partner"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the partner"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         ref="#/components/schemas/ImageResource",
 *         description="The image of the partner"
 *     )
 * )
 */
class PartnersResource extends JsonResource
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
            'image' => new ImageResource($this->image),
        ];
    }
}
