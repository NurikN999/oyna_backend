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

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *    path="/api/users",
     *   tags={"Users"},
     *  summary="Get all users",
     * description="Get all users",
     * operationId="getAllUsers",
     * @OA\Response(
     *   response=200,
     * description="Users retrieved successfully",
     * @OA\JsonContent(
     *  @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/UserResource")),
     * )
     * )
     * )
     */
    public function index()
    {
        return response()->json([
            'data' => UserResource::collection($this->userService->all())
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *  path="/api/users/{user}",
     * tags={"Users"},
     * summary="Get user by id",
     * description="Get user by id",
     * operationId="showUser",
     * @OA\Parameter(
     *  name="user",
     * in="path",
     * description="User id",
     * required=true,
     * @OA\Schema(
     *  type="integer",
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="User retrieved successfully",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="object", ref="#/components/schemas/UserResource"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="User not found",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Not Found"),
     * )
     * )
     * )
     */
    public function show(User $user)
    {
        return response()->json([
            'data' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * @param User $user
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Patch(
     *  path="/api/users/{user}",
     * tags={"Users"},
     * summary="Update user by id",
     * description="Update user by id",
     * operationId="updateUser",
     * @OA\Parameter(
     *  name="user",
     * in="path",
     * description="User id",
     * required=true,
     * @OA\Schema(
     *  type="integer",
     * )
     * ),
     * @OA\RequestBody(
     *  required=true,
     * @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="User updated successfully",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="object", ref="#/components/schemas/UserResource"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="User not found",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Not Found"),
     * )
     * )
     * )
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $user = $this->userService->update($user, $request->validated());

        return response()->json([
            'data' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Delete(
     *  path="/api/users/{user}",
     * tags={"Users"},
     * summary="Delete user by id",
     * description="Delete user by id",
     * operationId="deleteUser",
     * @OA\Parameter(
     *  name="user",
     * in="path",
     * description="User id",
     * required=true,
     * @OA\Schema(
     *  type="integer",
     * )
     * ),
     * @OA\Response(
     * response=204,
     * description="User deleted successfully",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="null"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="User not found",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Not Found"),
     * )
     * )
     * )
     */
    public function destroy(User $user, Request $request)
    {
        $this->userService->delete($user);
        return response()->json([
            'data' => null
        ], Response::HTTP_NO_CONTENT);
    }

}
