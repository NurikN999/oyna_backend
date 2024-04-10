<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            ['type' => 'quiz'],
            ['type' => 'match'],
            ['type' => 'differences'],
        ];

        foreach ($games as $game) {
            \App\Models\Game::create($game);
        }
    }
}
