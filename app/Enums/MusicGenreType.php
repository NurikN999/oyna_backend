<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * @OA\Schema(
 *     schema="MusicGenreType",
 *     type="string",
 *     description="The genre of the music",
 *     enum={"pop", "rock", "jazz", "classic", "hip_hop", "electronic"}
 * )
 * @method static static POP()
 * @method static static ROCK()
 * @method static static JAZZ()
 * @method static static CLASSIC()
 * @method static static HIP_HOP()
 * @method static static ELECTRONIC()
 * @method static array all()
 */
enum MusicGenreType: string
{
    case POP = 'pop';
    case KAZAKH = 'kazakh';
    case JAZZ = 'jazz';
    case CLASSIC = 'classic';
    case COUNTRY = 'country';
    case FUNNY = 'funny';

    public static function titles(): array
    {
        return [
            self::POP->value => 'Поп',
            self::KAZAKH->value => 'Казахская музыка',
            self::JAZZ->value => 'Джаз',
            self::CLASSIC->value => 'Классика',
            self::FUNNY->value => 'Веселая',
            self::COUNTRY->value => 'Кантри',
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
