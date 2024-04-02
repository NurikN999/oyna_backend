<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\User;

class UserService
{
    public function all()
    {
        return User::all();
    }

    public function create(array $data): mixed
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
