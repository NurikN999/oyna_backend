<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateUserRequest",
 *     type="object",
 *     title="UpdateUserRequest",
 *     required={"first_name", "last_name", "email", "age", "interest", "teams", "city_id", "password"},
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="User first name"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="User last name"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="User email"
 *     ),
 *     @OA\Property(
 *         property="age",
 *         type="integer",
 *         description="User age"
 *     ),
 *     @OA\Property(
 *         property="interest",
 *         type="string",
 *         description="User interests"
 *     ),
 *     @OA\Property(
 *         property="teams",
 *         type="string",
 *         description="User teams"
 *     ),
 *     @OA\Property(
 *         property="city_id",
 *         type="integer",
 *         description="City id"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="User password"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="binary",
 *         description="User image"
 *     )
 * )
 */
class UpdateUserRequest extends FormRequest
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
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'string',
            'age' => 'numeric',
            'interest' => 'string',
            'teams' => 'string|max:255',
            'city_id' => 'numeric',
            'password' => 'string|min:8|confirmed',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
