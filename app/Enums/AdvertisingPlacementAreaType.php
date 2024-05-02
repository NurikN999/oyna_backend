<?php

namespace App\Enums;

/**
 * @OA\Schema(
 *     schema="AdvertisingPlacementAreaType",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="The value of the advertising placement area type",
 *         example="home_page"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The title of the advertising placement area type",
 *         example="Главная страница"
 *     )
 * )
 */
enum AdvertisingPlacementAreaType: string
{
    case HOME_PAGE = 'home_page';
    case SIDE_PANEL = 'side_panel';
    case AFTER_OYNA_BUTTON = 'after_oyna_button';

    public static function titles(): array
    {
        return [
            self::HOME_PAGE->value => 'Главная страница',
            self::SIDE_PANEL->value => 'Боковая панель',
            self::AFTER_OYNA_BUTTON->value => 'После кнопки "Ойна"',
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
