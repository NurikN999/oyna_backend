<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Difference;
use App\Models\DifferenceCoordinates;

class CoordinateService
{
    public function saveCoordinates(Difference $difference, array $coordinates): void
    {
        $coordinates = collect($coordinates)->map(function ($coordinateData) use ($difference) {
            return new DifferenceCoordinates([
                'difference_id' => $difference->id,
                'x' => $coordinateData['x'],
                'y' => $coordinateData['y'],
            ]);
        });

        $difference->coordinates()->saveMany($coordinates);
    }
}
