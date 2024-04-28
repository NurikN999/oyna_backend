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
 *         type="string",
 *         description="The level of the game",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="coordinates",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             required={"x", "y"},
 *             @OA\Property(property="x", type="number", format="float", example=10.5),
 *             @OA\Property(property="y", type="number", format="float", example=20.5)
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
            'coordinates.*.x' => 'float',
            'coordinates.*.y' => 'float',
        ];
    }
}
