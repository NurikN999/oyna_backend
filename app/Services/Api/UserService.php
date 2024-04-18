<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\User;

class UserService
{
    public function all(array $queryFilter = [])
    {
        $query = User::query();
        if (isset($queryFilter['has_prizes']) && $queryFilter['has_prizes']) {
            $query->has('prizes');
        }

        if (isset($queryFilter['has_prizes']) && !$queryFilter['has_prizes']) {
            $query->doesntHave('prizes');
        }

        if (isset($queryFilter['is_taxi_driver']) && $queryFilter['is_taxi_driver']) {
            $query->where('is_taxi_driver', $queryFilter['is_taxi_driver']);
        }

        return $query->paginate(10);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user = $user->fill($data);
        if (isset($data['city_id'])) {
            $user->city_id = $data['city_id'];
        }
        $user->save();

        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}
