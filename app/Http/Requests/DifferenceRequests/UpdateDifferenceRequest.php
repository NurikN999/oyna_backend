<?php

namespace App\Http\Requests\DifferenceRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateDifferenceRequest",
 *     type="object",
 *     required={"game_level", "coordinates"},
 *     @OA\Property(
 *         property="game_level",
 *         type="integer",
 *         description="The level of the game",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="coordinates",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             required={"x1", "y1", "x2", "y2"},
 *             @OA\Property(property="x1", type="integer", example=10),
 *             @OA\Property(property="y1", type="integer", example=20),
 *             @OA\Property(property="x2", type="integer", example=30),
 *             @OA\Property(property="y2", type="integer", example=40)
 *         ),
 *         description="The coordinates of the difference"
 *     )
 * )
 */
class UpdateDifferenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'game_level' => 'string',
            'coordinates' => 'array',
            'coordinates.*.x1' => 'float',
            'coordinates.*.y1' => 'float',
            'coordinates.*.x2' => 'float',
            'coordinates.*.y2' => 'float',
        ];
    }
}
