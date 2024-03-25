<?php

namespace App\Http\Requests\MusicRequest;

use App\Enums\MusicGenreType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreMusicRequest extends FormRequest
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
            'genre' => ['required', 'string', new Enum(MusicGenreType::class)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'required|file|mimes:mp3,mp4,wav',
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
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'genre.required' => 'Genre is required',
            'genre.string' => 'Genre must be a string',
            'genre.enum' => 'Genre must be one of: ' . implode(', ', MusicGenreType::titles()),
            'image.image' => 'Image must be an image',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg',
            'image.max' => 'Image may not be greater than 2048 kilobytes',
            'file.required' => 'File is required',
            'file.file' => 'File must be a file',
            'file.mimes' => 'File must be a file of type: mp3, mp4, wav',
        ];
    }
}
