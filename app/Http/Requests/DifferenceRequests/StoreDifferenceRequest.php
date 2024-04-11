<?php

namespace App\Http\Requests\DifferenceRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreDifferenceRequest",
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
class StoreDifferenceRequest extends FormRequest
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
            'game_level' => 'required|string',
            'game_id' => 'required|integer',
            'coordinates' => 'required|array',
            'coordinates.*.x1' => 'required|float',
            'coordinates.*.y1' => 'required|float',
            'coordinates.*.x2' => 'required|float',
            'coordinates.*.y2' => 'required|float',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'game_level.required' => 'Game level is required',
            'game_level.string' => 'Game level must be a string',
            'game_id.required' => 'Game id is required',
            'game_id.integer' => 'Game id must be an integer',
            'coordinates.required' => 'Coordinates are required',
            'coordinates.array' => 'Coordinates must be an array',
            'coordinates.*.x1.required' => 'X1 coordinate is required',
            'coordinates.*.x1.float' => 'X1 coordinate must be a float',
            'coordinates.*.y1.required' => 'Y1 coordinate is required',
            'coordinates.*.y1.float' => 'Y1 coordinate must be a float',
            'coordinates.*.x2.required' => 'X2 coordinate is required',
            'coordinates.*.x2.float' => 'X2 coordinate must be a float',
            'coordinates.*.y2.required' => 'Y2 coordinate is required',
            'coordinates.*.y2.float' => 'Y2 coordinate must be a float',
        ];
    }
}
