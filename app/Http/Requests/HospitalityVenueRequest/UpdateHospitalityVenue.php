<?php

namespace App\Http\Requests\HospitalityVenueRequest;

use App\Enums\HospitalityVenueType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @OA\Schema(
 *     schema="UpdateHospitalityVenue",
 *     type="object",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *     ),
 *     @OA\Property(
 *        property="city_id",
 *       type="integer",
 *    ),
 *   @OA\Property(
 *     property="image",
 *   type="string",
 * format="binary"
 *   )
 * )
 */
class UpdateHospitalityVenue extends FormRequest
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
            'title' => 'nullable|string',
            'type' => ['nullable','string', new Enum(HospitalityVenueType::class)],
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'city_id' => 'nullable|integer|exists:cities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
