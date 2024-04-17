<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     required={"first_name", "age", "phone_number"},
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="The first name of the user"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="The last name of the user"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="The email address of the user"
 *     ),
 *     @OA\Property(
 *         property="age",
 *         type="integer",
 *         description="The age of the user"
 *     ),
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         description="The phone number of the user"
 *     ),
 *     @OA\Property(
 *         property="interests",
 *         type="string",
 *         description="The interests of the user"
 *     ),
 *     @OA\Property(
 *         property="teams",
 *         type="string",
 *         description="The teams of the user"
 *     ),
 *     @OA\Property(
 *         property="city_id",
 *         type="integer",
 *         description="The ID of the city of the user"
 *     ),
 *     @OA\Property(
 *         property="unique_id",
 *         type="string",
 *         description="The unique ID of the user"
 *     ),
 *     example={
 *         "first_name": "John",
 *         "last_name": "Doe",
 *         "email": "john@example.com",
 *         "age": 30,
 *         "phone_number": "1234567890",
 *         "interests": "coding,reading",
 *         "teams": "team1,team2",
 *         "city_id": 1,
 *         "unique_id": "abc123"
 *     }
 * )
 */
class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email',
            'age' => 'required|integer',
            'phone_number' => 'required|string',
            'interests' => 'nullable|string',
            'teams' => 'nullable|string',
            'city_id' => 'nullable|integer|exists:cities,id',
            'unique_id' => 'nullable|string',
        ];
    }
}
