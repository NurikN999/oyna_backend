<?php

namespace App\Http\Requests\EntertainmentRequest;

use Illuminate\Foundation\Http\FormRequest;

class EntertainmentStoreRequest extends FormRequest
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
            'type' => 'required|string',
            'title' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'city_id' => 'required|integer|exists:cities,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ];
    }
}
