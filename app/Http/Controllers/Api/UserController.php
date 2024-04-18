<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\UpdateUserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Services\Api\ImageService;
use App\Services\Api\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private UserService $userService;
    private ImageService $imageService;

    public function __construct(UserService $userService, ImageService $imageService)
    {
        $this->userService = $userService;
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *    path="/api/users",
     *    tags={"Users"},
     *    summary="Get all users",
     *    description="Get all users. You can filter users who have prizes by adding the 'has_prizes' query parameter. Set it to 'true' to get users who have prizes, and 'false' to get users who don't have prizes.",
     *    operationId="getAllUsers",
     *    @OA\Parameter(
     *        name="has_prizes",
     *        in="query",
     *        description="Whether the user has prizes or not",
     *        required=false,
     *        @OA\Schema(
     *            type="boolean"
     *        )
     *    ),
     *     @OA\Parameter(
     *        name="is_taxi_driver",
     *        in="query",
     *        description="Whether the user taxi driver or not",
     *        required=false,
     *        @OA\Schema(
     *            type="boolean"
     *        )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Users retrieved successfully",
     *        @OA\JsonContent(
     *            @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/UserResource")),
     *        )
     *    )
     * )
     */
    public function index(Request $request)
    {
        $queryFilter = $request->all();
        return response()->json([
            'data' => UserResource::collection($this->userService->all($queryFilter))
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
        $data = $request->validated();
        $user = $this->userService->update($user, $data);

        if ($data['image']) {
            $this->imageService->upload($data['image'], User::class, $user->id);
        }

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
