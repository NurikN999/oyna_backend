<?php

namespace App\Enums;

/**
 * @OA\Schema(
 *     schema="GameLevelType",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="The value of the game level type",
 *         example="easy"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The title of the game level type",
 *         example="Легкий"
 *     )
 * )
 */
enum GameLevelType: string {
    case Easy = 'easy';
    case Medium = 'medium';
    case Hard = 'hard';

    public static function titles(): array
    {
        return [
            self::Easy->value => 'Легкий',
            self::Medium->value => 'Средний',
            self::Hard->value => 'Сложный',
        ];
    }

    public static function all(): array
    {
        $data = [];
        foreach (self::cases() as $item) {
            $data[] = [
                'id' => $item->value,
                'name' => self::titles()[$item->value],
            ];
        }

        return $data;
    }
}
