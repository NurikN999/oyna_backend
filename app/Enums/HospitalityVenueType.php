<?php

declare(strict_types=1);

namespace App\Enums;

enum HospitalityVenueType: string
{
    case RESTAURANT = 'restaurant';
    case HOTEL = 'hotel';

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

    public static function titles(): array
    {
        return [
            self::RESTAURANT->value => 'Ресторан',
            self::HOTEL->value => 'Гостиница',
        ];
    }
}
