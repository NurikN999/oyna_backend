<?php

namespace App\Http\Requests\HospitalityVenueRequest;

use App\Enums\HospitalityVenueType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @OA\Schema(
 *     schema="StoreHospitalityVenueRequest",
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
 *      @OA\Property(
 *         property="city_id",
 *         type="integer",
 *     ),
 *    @OA\Property(
 *        property="image",
 *       type="string",
 *     format="binary"
 *    )
 * )
 */
class StoreHospitalityVenueRequest extends FormRequest
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
            'type' => ['required','string', new Enum(HospitalityVenueType::class)],
            'address' => 'required|string',
            'description' => 'required|string',
            'city_id' => 'required|integer|exists:cities,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
