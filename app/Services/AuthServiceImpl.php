<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthServiceImpl implements AuthService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $data): ?array
    {
        DB::beginTransaction();

        if (Auth::attempt($data)) {
            try {
                $user = $this->userRepository->findByEmail($data['email']);
                $token = $user->createToken('access-token');
                $role = $user->role;

                DB::commit();

                return [
                    'token' => $token->plainTextToken,
                    'role' => $role
                ];
            } catch (\Throwable $th) {
                DB::rollBack();
                throw new Exception($th->getMessage(), 500);
            }
        }

        return null;
    }

    public function register(array $data): ?array
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->role = 'cashier';

            $save = $this->userRepository->create($user);
            $token = $user->createToken('access-token');
            $role = $user->role;

            DB::commit();

            if ($save) {
                return [
                    'token' => $token->plainTextToken,
                    'role' => $role
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage(), 500);
        }

        return null;
    }
}
