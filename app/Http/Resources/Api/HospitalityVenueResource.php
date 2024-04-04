<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalityVenueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @param Request $request
     * @return array
     * @OA\Schema(
     * schema="HospitalityVenueResource",
     * required={"id", "title", "type", "address", "description", "city", "image"},
     * @OA\Property(
     * property="id",
     * type="integer",
     * example="1"
     * ),
     * @OA\Property(
     * property="title",
     * type="string",
     * example="Hospitality Venue title"
     * ),
     * @OA\Property(
     * property="type",
     * type="string",
     * example="Hospitality Venue type"
     * ),
     * @OA\Property(
     * property="address",
     * type="string",
     * example="Hospitality Venue address"
     * ),
     * @OA\Property(
     * property="description",
     * type="string",
     * example="Hospitality Venue description"
     * ),
     * @OA\Property(
     * property="city",
     * ref="#/components/schemas/CityResource"
     * ),
     * @OA\Property(
     * property="image",
     * ref="#/components/schemas/ImageResource"
     * )
     * )
     *
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'address' => $this->address,
            'description' => $this->description,
            'city' => new CityResource($this->city),
            'image' => new ImageResource($this->image),
        ];
    }
}
