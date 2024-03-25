<?php

namespace App\Http\Requests\MusicRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMusicRequest extends FormRequest
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
            'genre' => 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'file|mimes:mp3,mp4,wav',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.string' => 'Title must be a string',
            'genre.string' => 'Genre must be a string',
            'image.image' => 'Image must be an image',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg',
            'image.max' => 'Image may not be greater than 2048 kilobytes',
            'file.file' => 'File must be a file',
            'file.mimes' => 'File must be a file of type: mp3, mp4, wav',
        ];
    }
}
