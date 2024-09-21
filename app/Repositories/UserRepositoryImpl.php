<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepositoryImpl implements UserRepository
{
    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }

    public function findById(int $id): User
    {
        return User::find($id);
    }

    public function findAll(): array
    {
        return User::all()->toArray();
    }

    public function update(User $user): bool
    {
        return User::find($user->id)->update($user);
    }

    public function create(User $user): bool
    {
        return User::create($user);
    }
}
