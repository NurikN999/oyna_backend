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
                'card_id' => $difference->id,
                'x1' => $coordinateData['x1'],
                'y1' => $coordinateData['y1'],
                'x2' => $coordinateData['x2'],
                'y2' => $coordinateData['y2'],
            ]);
        });

        $difference->coordinates()->saveMany($coordinates);
    }
}
