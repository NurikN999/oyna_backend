<?php

namespace App\Http\Requests\BannerRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateBannerRequest",
 *     type="object",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the banner",
 *         example="Updated Banner"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the banner",
 *         example="This is an updated banner"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="string",
 *         format="binary",
 *         description="The updated image of the banner"
 *     )
 * )
 */
class UpdateBannerRequest extends FormRequest
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
            'title' => 'string',
            'description' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
