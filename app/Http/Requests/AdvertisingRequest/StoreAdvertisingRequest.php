<?php

namespace App\Http\Requests\AdvertisingRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   schema="StoreAdvertisingRequest",
 *   type="object",
 *   required={"title", "placement_area", "play_time", "description", "video"},
 *   @OA\Property(property="title", type="string", example="Advertising title"),
 *   @OA\Property(property="placement_area", type="string", example="Advertising placement area"),
 *   @OA\Property(property="play_time", type="string", format="date", example="2021-10-10"),
 *   @OA\Property(property="description", type="string", example="Advertising description"),
 *   @OA\Property(property="video", type="string", format="binary"),
 *   @OA\Property(property="video_link", type="string", example="http://example.com/video.mp4"),
 * )
 */
class StoreAdvertisingRequest extends FormRequest
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
            'placement_area' => 'required|string',
            'play_time' => 'required|date',
            'description' => 'required|string',
            'video' => 'required|file|mimes:mp4,mov,avi,wmv',
            'video_link' => ['required_if:video,null', 'url'],
        ];
    }
}
