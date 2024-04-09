<?php

namespace App\Http\Requests\AdvertisingRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateAdvertisingRequest
 * @package App\Http\Requests\AdvertisingRequest
 * @OA\Schema(
 *     title="UpdateAdvertisingRequest",
 *     description="Update advertising request",
 *     required={"title", "placement_area", "play_time", "description", "video", "video_link"},
 * )
 */
class UpdateAdvertisingRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'placement_area' => 'nullable|string|max:255',
            'play_time' => 'nullable|integer',
            'description' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,mov,avi,3gp,wmv,flv,webm|max:200000',
            'video_link' => 'nullable|string',
        ];
    }
}
