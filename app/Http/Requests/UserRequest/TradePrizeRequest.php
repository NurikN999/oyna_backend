<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="TradePrizeRequest",
 *     required={"points", "prize_id", "city_id", "address"},
 *     @OA\Property(
 *         property="points",
 *         type="integer",
 *         description="The number of points to trade"
 *     ),
 *     @OA\Property(
 *         property="prize_id",
 *         type="integer",
 *         description="The ID of the prize"
 *     ),
 *     @OA\Property(
 *         property="city_id",
 *         type="integer",
 *         description="The ID of the city"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="The address for the prize delivery"
 *     ),
 * )
 */
class TradePrizeRequest extends FormRequest
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
            'points' => 'required|integer',
            'prize_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'points.required' => 'Поле "points" обязательно для заполнения',
            'points.integer' => 'Поле "points" должно быть числом',
            'prize_id.required' => 'Поле "prize_id" обязательно для заполнения',
            'prize_id.integer' => 'Поле "prize_id" должно быть числом',
            'city_id.required' => 'Поле "city_id" обязательно для заполнения',
            'city_id.integer' => 'Поле "city_id" должно быть числом',
            'address.required' => 'Поле "address" обязательно для заполнения',
            'address.string' => 'Поле "address" должно быть строкой',
        ];
    }
}
