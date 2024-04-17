<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     required={"phone_number", "unique_id"},
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         format="phone_number",
 *         description="The phone_number address of the user"
 *     ),
 *     @OA\Property(
 *         property="unique_id",
 *         type="string",
 *         format="unique_id",
 *         description="The unique_id of the user"
 *     ),
 *     example={"phone_number": "+777777777", "unique_id": "string"}
 * )
 */
class LoginRequest extends FormRequest
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
            'phone_number' => 'required|string',
            'unique_id' => 'nullable|string',
        ];
    }
}
