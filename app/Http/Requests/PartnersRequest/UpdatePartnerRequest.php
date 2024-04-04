<?php

namespace App\Http\Requests\PartnersRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdatePartnerRequest",
 *     type="object",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the partner"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the partner"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="string",
 *         format="binary",
 *         description="The image of the partner"
 *     )
 * )
 */
class UpdatePartnerRequest extends FormRequest
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
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
