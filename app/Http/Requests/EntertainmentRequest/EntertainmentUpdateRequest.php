<?php

namespace App\Http\Requests\EntertainmentRequest;

use Illuminate\Foundation\Http\FormRequest;

class EntertainmentUpdateRequest extends FormRequest
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
            'type' => 'nullable|string',
            'title' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'city_id' => 'nullable|integer|exists:cities,id',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg'
        ];
    }
}
