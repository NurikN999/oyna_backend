<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PointsService
{
    public const CACHE_TTL = 60 * 24;

    public function cachePendingPoints($points)
    {
        $uniqueId = Str::uuid()->toString();

        Cache::put($uniqueId, $points, self::CACHE_TTL);

        return $uniqueId;
    }

    public function redeemPoints($userId, $uniqueId)
    {
        $points = Cache::pull($uniqueId);

        if ($points === null) {
            return ['error' => 'Баллы не найдены или время их действия истекло.'];
        }

        DB::transaction(function () use ($userId, $points) {
            $user = User::find($userId);
            $pointsRecord = $user->points->firstOrCreate([]);
            $pointsRecord->balance += $points;
            $pointsRecord->save();

            $user->pointsHistory()->create([
                'amount_change' => $points,
                'description' => 'Начисление баллов за завершение игры',
            ]);
        });

        return ['success' => 'Баллы успешно начислены.'];
    }
}
