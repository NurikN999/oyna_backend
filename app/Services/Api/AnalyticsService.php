<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\User;

class AnalyticsService
{

    public function getAnalytics(string $query, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $data = [
            'users_by_age_range' => [],
        ];

        if ($query === 'age' || $query === 'all') {
            $data['users_by_age_range'] = [
                    '18-25' => $this->getPercentageOfUsersByAgeRange(18, 25, $dateFrom, $dateTo),
                    '26-34' => $this->getPercentageOfUsersByAgeRange(26, 34, $dateFrom, $dateTo),
                    '34-45' => $this->getPercentageOfUsersByAgeRange(34, 45, $dateFrom, $dateTo),
                    '45+' => $this->getPercentageOfUsersByAgeRange(45, 100, $dateFrom, $dateTo),
            ];
        }


        return $data;
    }

    private function getPercentageOfUsersByAgeRange($startAge, $endAge, $dateFrom = null, $dateTo = null): float
    {
        $totalUsers = User::where('is_taxi_driver', false)->count();
        $ageGroupCount = User::where('is_taxi_driver', false)
            ->whereBetween('age', [$startAge, $endAge])
            ->count();

        if ($dateFrom && $dateTo) {
            $totalUsers = User::where('is_taxi_driver', false)
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->count();

            $ageGroupCount = User::where('is_taxi_driver', false)
                ->whereBetween('age', [$startAge, $endAge])
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->count();
        }

        return $totalUsers > 0 ? round(($ageGroupCount / $totalUsers) * 100) : 0;
    }

}
