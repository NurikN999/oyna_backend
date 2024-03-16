<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\UpdateUserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Services\Api\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return response()->json([
            'data' => UserResource::collection($this->userService->all())
        ], Response::HTTP_OK);
    }

    public function show(User $user, Request $request)
    {

    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $user = $this->userService->update($user, $request->validated());

        return response()->json([
            'data' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    public function destroy(User $user, Request $request)
    {
        $this->userService->delete($user);
        return response()->json([
            'data' => null
        ], Response::HTTP_NO_CONTENT);
    }

}
