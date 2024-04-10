<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Game
 * @psalm-suppress MissingReturnType
 * @OA\Schema(
 *    schema="GameResource",
 *   @OA\Property(
 *    property="id",
 *   type="integer",
 *  format="int64",
 * ),
 * @OA\Property(
 *   property="type",
 * type="string",
 * ),
 * )
 * @OA\Schema(
 *   schema="GameResourceCollection",
 * type="array",
 * @OA\Items(ref="#/components/schemas/GameResource"),
 * )
 * )
 */
class GameResource extends JsonResource
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
            'type' => $this->type,
        ];
    }
}
