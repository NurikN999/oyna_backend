<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Алматы'],
            ['name' => 'Астана'],
            ['name' => 'Актобе'],
            ['name' => 'Актау'],
            ['name' => 'Атырау'],
            ['name' => 'Караганда'],
            ['name' => 'Кокшетау'],
            ['name' => 'Костанай'],
            ['name' => 'Кызылорда'],
            ['name' => 'Павлодар'],
            ['name' => 'Петропавловск'],
            ['name' => 'Семей'],
            ['name' => 'Талдыкорган'],
            ['name' => 'Тараз'],
            ['name' => 'Туркестан'],
            ['name' => 'Уральск'],
            ['name' => 'Усть-Каменогорск'],
            ['name' => 'Шымкент'],
            ['name' => 'Жезказган'],
            ['name' => 'Жанаозен'],
        ];

        foreach ($cities as $city) {
            \App\Models\City::create($city);
        }
    }
}
