<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Game
 * @psalm-suppress MissingReturnType
 * @OA\Schema(
 *     schema="GameResource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The ID of the game",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="The type of the game",
 *         example="Quiz"
 *     ),
 *     @OA\Property(
 *         property="quiz",
 *         ref="#/components/schemas/QuizQuestionResource",
 *         description="The quiz associated with the game (if type is 'Quiz')"
 *     ),
 *     @OA\Property(
 *         property="difference",
 *         ref="#/components/schemas/DifferenceResource",
 *         description="The differences associated with the game (if type is 'Difference')"
 *     )
 * )
 * @OA\Schema(
 *     schema="GameResourceCollection",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/GameResource"),
 *     description="A collection of games"
 * )
 */
class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
        ];

        if ($this->type === 'quiz' && $this->questions !== null) {
            $data['questions'] = QuizQuestionResource::collection($this->questions);
        }

        if ($this->type === 'difference' && $this->differences !== null) {
            $data['differences'] = DifferenceResource::collection($this->differences);
        }

        return $data;
    }
}
