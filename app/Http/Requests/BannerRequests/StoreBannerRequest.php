<?php

namespace App\Http\Requests\BannerRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreBannerRequest",
 *     type="object",
 *     required={"title", "description", "image"},
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the banner",
 *         example="Sample Banner"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the banner",
 *         example="This is a sample banner"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="string",
 *         format="binary",
 *         description="The image of the banner"
 *     )
 * )
 */
class StoreBannerRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
