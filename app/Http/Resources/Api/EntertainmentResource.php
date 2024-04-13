<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntertainmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @param Request $request
     * @return array
     * @OA\Schema(
     *  schema="EntertainmentResource",
     * required={"id", "type", "title", "address", "description", "city_id", "image"},
     * @OA\Property(
     *    property="id",
     *   type="integer",
     *  example="1"
     * ),
     * @OA\Property(
     *   property="type",
     *  type="string",
     * example="Entertainment"
     * ),
     * @OA\Property(
     *  property="title",
     * type="string",
     * example="Entertainment title"
     * ),
     * @OA\Property(
     * property="address",
     * type="string",
     * example="Entertainment address"
     * ),
     * @OA\Property(
     * property="description",
     * type="string",
     * example="Entertainment description"
     * ),
     * @OA\Property(
     * property="city_id",
     * type="integer",
     * example="1"
     * ),
     * @OA\Property(
     * property="image",
     * ref="#/components/schemas/ImageResource"
     * )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'address' => $this->address,
            'description' => $this->description,
            'city' => new CityResource($this->city),
            'image' => new ImageResource($this->image),
        ];
    }
}
