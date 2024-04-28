<?php

namespace App\Http\Requests\DifferenceRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreDifferenceRequest",
 *     type="object",
 *     required={"game_level", "game_id", "coordinates", "images"},
 *     @OA\Property(
 *         property="game_level",
 *         type="string",
 *         description="The level of the game",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="game_id",
 *         type="integer",
 *         description="The ID of the game",
 *         example=1
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
 *     ),
 *     @OA\Property(
 *         property="images",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             format="binary"
 *         ),
 *         description="The images of the difference"
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
            'coordinates' => 'required|array',
            'coordinates.*.x' => 'required|numeric',
            'coordinates.*.y' => 'required|numeric',
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
