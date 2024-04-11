<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed text
 * @property mixed is_correct
 * @property mixed quiz_question_id
 * @property mixed image
 * @OA\Schema(
 *    schema="OptionResource",
 *   required={"id", "text", "is_correct", "quiz_question_id", "image"},
 *  @OA\Property(property="id", type="integer", example="1"),
 * @OA\Property(property="text", type="string", example="Option 1"),
 * @OA\Property(property="is_correct", type="boolean", example="true"),
 * @OA\Property(property="quiz_question_id", type="integer", example="1"),
 * @OA\Property(property="image", ref="#/components/schemas/ImageResource"),
 * )
 */
class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'is_correct' => $this->is_correct,
            'quiz_question_id' => $this->quiz_question_id,
            'image' => new ImageResource($this->image),
        ];
    }
}
