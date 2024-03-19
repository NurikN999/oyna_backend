<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\CityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'city' => new CityResource($this->city),
            'created_at' => $this->created_at
        ];
    }
}
