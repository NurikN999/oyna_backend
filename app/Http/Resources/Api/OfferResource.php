<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @param Request $request
     * @return array
     * @OA\Schema(
     *     schema="OfferResource",
     *     type="object",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="The ID of the offer"
     *     ),
     *     @OA\Property(
     *         property="text",
     *         type="string",
     *         description="The text of the offer"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text
        ];
    }
}
