<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Services\Api\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = array_merge(
                $request->validated(),
                [
                    'is_active' => true
                ]
            );
            $user = $this->userService->create($data);
            $token = JWTAuth::fromUser($user);
            return response()->json(
                [
                    'message' => 'User created successfully',
                    'data' => [
                        'token' => $token,
                        'user' => new UserResource($user)
                    ]
                ], 201);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage()
                ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(
                    [
                        'message' => 'Invalid credentials'
                    ], 401);
            }
            return response()->json(
                [
                    'message' => 'User logged in successfully',
                    'data' => [
                        'token' => $token,
                        'user' => new UserResource(auth()->user())
                    ]
                ], 200);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage()
                ], 500);
        }
    }


}
