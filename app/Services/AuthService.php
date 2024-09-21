<?php

namespace App\Services;

interface AuthService
{
    public function login(array $data) : ?array;
    public function register(array $data) : ?array;
}
