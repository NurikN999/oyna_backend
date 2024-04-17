<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\CityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UserResource",
 *     type="object",
 *     title="UserResource",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="User id"
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="User first name"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="User last name"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="User email"
 *     ),
 *     @OA\Property(
 *         property="age",
 *         type="integer",
 *         description="User age"
 *     ),
 *     @OA\Property(
 *         property="interests",
 *         type="string",
 *         description="User interests"
 *     ),
 *     @OA\Property(
 *         property="teams",
 *         type="string",
 *         description="User teams"
 *     ),
 *     @OA\Property(
 *         property="is_active",
 *         type="boolean",
 *         description="User is active"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         ref="#/components/schemas/CityResource"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         ref="#/components/schemas/ImageResource"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         description="User created at"
 *     )
 *     @OA\Property(
 *         property="points",
 *         type="integer",
 *         description="User points"
 *     )
 * )
 */
class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'age' => $this->age,
            'interests' => $this->interests,
            'teams' => $this->teams,
            'is_active' => $this->is_active,
            'points' => $this->points ? $this->points->balance : 0,
            'city' => new CityResource($this->city),
            'image' => new ImageResource($this->image),
            'created_at' => $this->created_at
        ];
    }
}
