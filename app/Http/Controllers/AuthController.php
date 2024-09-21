<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryImpl;
use App\Services\AuthService;
use App\Services\AuthServiceImpl;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    private AuthService $authService;

    public function __construct()
    {
        $userRepository = new UserRepositoryImpl();
        $this->authService = new AuthServiceImpl($userRepository);
    }

    function login(Request $req): JsonResponse
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        return response()->json(
            [
                "message" => "Login success",
                "status" => 200,
                "data" => $this->authService->login($req->all())
            ]
        );
    }

    function register(Request $req): JsonResponse
    {
        $req->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'name' => 'required'
        ]);

        return response()->json(
            [
                "message" => "Register success",
                "status" => 200,
                "data" => $this->authService->register($req->all())
            ]
        );
    }

    function logout(Request $req): JsonResponse
    {
        // Revoke the token that was used to authenticate the current request...
        $req->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out!'
        ], 200);
    }

    function changePassword(Request $req): JsonResponse
    {
        $req->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8'
        ]);

        $user = $req->user();

        if (!Hash::check($req->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is wrong'
            ], 401);
        }

        $user->password = bcrypt($req->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password successfully updated'
        ], 200);
    }
}
