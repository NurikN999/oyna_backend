<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="DifferenceResource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the difference",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="game_level",
 *         type="integer",
 *         description="The level of the game",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="game_id",
 *         type="integer",
 *         description="The ID of the game",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="coordinates",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/CoordinateResource"),
 *         description="The coordinates of the difference"
 *     ),
 *     @OA\Property(
 *         property="images",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ImageResource"),
 *         description="The images of the difference"
 *     )
 * )
 */
class DifferenceResource extends JsonResource
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
            'game_level' => $this->game_level,
            'game_id' => $this->game_id,
            'coordinates' => CoordinateResource::collection($this->coordinates),
            'images' => ImageResource::collection($this->images),
        ];
    }
}
