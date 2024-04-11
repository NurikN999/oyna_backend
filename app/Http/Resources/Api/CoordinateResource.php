<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CoordinateResource",
 *     type="object",
 *     @OA\Property(
 *         property="x1",
 *         type="integer",
 *         description="The x1 coordinate",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="y1",
 *         type="integer",
 *         description="The y1 coordinate",
 *         example=20
 *     ),
 *     @OA\Property(
 *         property="x2",
 *         type="integer",
 *         description="The x2 coordinate",
 *         example=30
 *     ),
 *     @OA\Property(
 *         property="y2",
 *         type="integer",
 *         description="The y2 coordinate",
 *         example=40
 *     )
 * )
 */
class CoordinateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'x1' => $this->x1,
            'y1' => $this->y1,
            'x2' => $this->x2,
            'y2' => $this->y2,
        ];
    }
}
