<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * @OA\Schema(
 *     schema="EntertainmentType",
 *     type="string",
 *     description="The genre of the music",
 *     enum={"game_center", "cinema", "theater", "museum", "park", "anticafe"}
 * )
 * @method static static POP()
 * @method static static ROCK()
 * @method static static JAZZ()
 * @method static static CLASSIC()
 * @method static static HIP_HOP()
 * @method static static ELECTRONIC()
 * @method static array all()
 */
enum EntertainmentType: string
{
    case GAME_CENTER = 'game_center';
    case CINEMA = 'cinema';
    case THEATER = 'theater';
    case MUSEUM = 'museum';
    case PARK = 'park';
    case ANTICAFE = 'anticafe';

    public static function titles(): array
    {
        return [
            self::GAME_CENTER->value => 'Игровой центр',
            self::CINEMA->value => 'Кинотеатр',
            self::THEATER->value => 'Театр',
            self::MUSEUM->value => 'Музей',
            self::PARK->value => 'Парк',
            self::ANTICAFE->value => 'Антикафе',
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
