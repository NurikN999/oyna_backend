<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\User;

class UserService
{
    public function create(array $data): mixed
    {
        return User::create($data);
    }
}
