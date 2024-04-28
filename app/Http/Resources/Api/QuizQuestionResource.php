<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="QuizQuestionResource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the quiz question",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="text",
 *         type="string",
 *         description="The text of the quiz question",
 *         example="What is the capital of France?"
 *     ),
 *     @OA\Property(
 *         property="quiz_id",
 *         type="integer",
 *         description="The ID of the quiz that the question belongs to",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="options",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/OptionResource"),
 *         description="The options of the quiz question"
 *     )
 * )
 */
class QuizQuestionResource extends JsonResource
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
            'game_id' => $this->game_id,
            'image' => new ImageResource($this->image),
            'options' => OptionResource::collection($this->options),
        ];
    }
}
