<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    public function findByPhonenumber(string $phonenumber): ?User
    {
        return User::where('phonenumber', $phonenumber)->first();
    }
}