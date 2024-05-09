<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\Jobs\SendVerificationCode;
use App\Models\Point;
use App\Models\User;
use App\Services\Api\PointsService;
use App\Services\Api\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private UserService $userService;
    private PointsService $pointsService;

    public function __construct(UserService $userService, PointsService $pointsService)
    {
        $this->userService = $userService;
        $this->pointsService = $pointsService;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register a new user",
     *     description="Register a new user, send a verification code via SMS, and return a message.",
     *     operationId="register",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         description="Input data format",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Мы отправили SMS с кодом подтверждения на ваш номер телефона 1234567890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred"
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        try {
            if (User::where('phone_number', $request->phone_number)->exists()) {
                return response()->json(
                    [
                        'message' => 'Пользователь с таким номером телефона уже существует'
                    ],
                    400
                );
            }
            $data = array_merge(
                $request->validated(),
                [
                    'is_active' => true
                ]
            );
            $user = new User($data);
            $code = rand(10000, 99999);

            dispatch(new SendVerificationCode($user->phone_number, $code));

            Cache::put($user->phone_number, [
                'code' => $code,
                'unique_id' => $request->unique_id,
                'user' => $user
            ], now()->addMinutes(20));

            return response()->json(
                [
                    'message' => 'Мы отправили SMS с кодом подтверждения на ваш номер телефона ' . $user->phone_number,
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Login an existing user",
     *     description="Login an existing user, send a verification code via SMS, and return a message.",
     *     operationId="login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         description="Input data format",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Мы отправили SMS с кодом подтверждения на ваш номер телефона 1234567890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $phoneNumber = $request->input('phone_number');
        $user = User::where('phone_number', $phoneNumber)->first();

        if (!$user) {
            return response()->json(
                [
                     'message' => 'Пользователь с таким номером телефона не найден'
                ],
                404
            );
        }

        $code = rand(10000, 99999);

        dispatch(new SendVerificationCode($phoneNumber, $code));

        Cache::put($user->phone_number, [
            'code' => $code,
            'unique_id' => $request->unique_id,
        ], now()->addMinutes(20));

        return response()->json(
            [
                'message' => 'Мы отправили SMS с кодом подтверждения на ваш номер телефона ' . $phoneNumber,
            ],
            200
        );

    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout the authenticated user",
     *     description="Logout the authenticated user and return a message.",
     *     operationId="logout",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User logged out successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred"
     *     )
     * )
     */
    public function logout()
    {
        try {
            $this->userService->update(JWTAuth::parseToken()->authenticate(), ['is_active' => false]);
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(
                [
                    'message' => 'User logged out successfully'
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/verify",
     *     summary="Verify a user's phone number",
     *     description="Verify a user's phone number using a code, log in or register the user, and return a token and user data.",
     *     operationId="verify",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         description="Input data format",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="phone_number", type="string", description="The phone number of the user"),
     *             @OA\Property(property="code", type="string", description="The verification code"),
     *             example={"phone_number": "1234567890", "code": "12345"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User logged in successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="token", type="string", description="The JWT token"),
     *                 @OA\Property(property="user", type="object", ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid verification code"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Verification code not found"
     *     )
     * )
     */
    public function verify(Request $request)
    {
        $data = Cache::get($request->phone_number);

        if (!$data) {
            return response()->json(
                [
                      'message' => 'Код подтверждения не найден'
                 ],
                404
            );
        }

        if ($data['code'] != $request->code) {
            return response()->json(
                [
                       'message' => 'Неверный код подтверждения'
                ],
                400
            );
        }

        Cache::forget($request->phone_number);

        $user = User::where('phone_number', $request->phone_number)->first();

        if ($user) {
            $token = JWTAuth::fromUser($user);
            $message = 'User logged in successfully';
        } else {
            $user = $data['user'];
            $user->is_active = true;
            $user->save();

            Point::create([
                'user_id' => $user->id,
                'balance' => 0
            ]);

            $token = JWTAuth::fromUser($user);
            $message = 'User registered successfully';
        }

        if ($data['unique_id']) {
            $pointsResult = $this->pointsService->redeemPoints($user->id, $data['unique_id']);
        }

        return response()->json(
            array_merge(
                [
                    'message' => $message,
                    'data' => [
                        'token' => $token,
                        'user' => new UserResource($user)
                    ]
                ],
                $pointsResult ?? [],
            ),
            200
        );
    }

}
