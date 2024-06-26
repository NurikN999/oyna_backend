<?php

namespace App\Http\Requests\QuizQuestionRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="UpdateQuizQuestionRequest",
 *     required={"text", "options"},
 *     @OA\Property(
 *         property="text",
 *         type="string",
 *         example="What is the capital of France?"
 *     ),
 *     @OA\Property(
 *         property="options",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(
 *                 property="text",
 *                 type="string",
 *                 example="Paris"
 *             ),
 *             @OA\Property(
 *                 property="is_correct",
 *                 type="boolean",
 *                 example=true
 *             ),
 *             @OA\Property(
 *                 property="image",
 *                 type="string",
 *                 format="binary"
 *             )
 *         )
 *     )
 * )
 */
class UpdateQuizQuestionRequest extends FormRequest
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
            'text' => 'nullable|string',
            'options' => 'nullable|array',
            'image' => 'nullable|image',
            'options.*.text' => 'nullable|string',
            'options.*.id' => 'nullable|string',
            'options.*.is_correct' => 'nullable|string',
        ];
    }
}
