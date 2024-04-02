<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @param Request $request
     * @throws \JsonException
     * @noinspection PhpUndefinedMethodInspection
     * @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUnusedParameterInspection
     * @noinspection PhpUnused
     * @OA\Schema(
     *      schema="CityResource",
     *      title="CityResource",
     *      description="City resource",
     *      @OA\Property(
     *          property="id",
     *          type="integer",
     *          description="City id"
     *      ),
     *      @OA\Property(
     *          property="name",
     *          type="string",
     *          description="City name"
     *  )
     * )
     * @OA\Schema(
     *   schema="CityResourceCollection",
     * title="CityResourceCollection",
     * description="City resource collection",
     * @OA\Property(
     *  property="data",
     * type="array",
     * @OA\Items(ref="#/components/schemas/CityResource")
     * )
     * )
     *
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
