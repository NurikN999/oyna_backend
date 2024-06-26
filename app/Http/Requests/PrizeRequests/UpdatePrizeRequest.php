<?php

namespace App\Http\Requests\PrizeRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdatePrizeRequest",
 *     type="object",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the prize"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the prize"
 *     ),
 *     @OA\Property(
 *         property="point_amount",
 *         type="integer",
 *         description="Point amount of the prize"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="string",
 *         format="binary",
 *         description="The image of the prize"
 *     )
 * )
 */
class UpdatePrizeRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'point_amount' => 'nullable|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
