<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

interface UserRepository
{
    public function findByEmail( string $email): User;
    public function findById(int $id): User;
    public function findAll(): array;
    public function update(User $user): bool;
    public function create(User $user): bool;
}
