<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GameResource;
use App\Models\Game;
use App\Services\Api\PointsService;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private PointsService $pointsService;

    public function __construct(PointsService $pointsService)
    {
        $this->pointsService = $pointsService;
    }
    /**
     * @OA\Get(
     *     path="/api/games",
     *     summary="Get a list of games",
     *     description="Get a paginated list of games",
     *     operationId="getGames",
     *     tags={"Games"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/GameResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $games = Game::all();

        return response()->json([
            'data' => GameResource::collection($games),
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/games/{id}",
     *     summary="Get a specific game",
     *     description="Get a specific game by its id",
     *     operationId="getGameById",
     *     tags={"Games"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the game to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/GameResource")
     *     )
     * )
     */
    public function show(Game $game)
    {
        return response()->json([
            'data' => new GameResource($game),
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/game/finish",
     *     tags={"Games"},
     *     summary="Finish a game",
     *     description="Finish a game and cache the points. Returns a unique ID for retrieving the points later.",
     *     operationId="finishGame",
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="points",
     *                     description="The points earned in the game",
     *                     type="integer"
     *                 ),
     *                 required={"points"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game finished successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="The response message"),
     *             @OA\Property(property="unique_id", type="string", description="The unique ID for retrieving the points"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function finishGame(Request $request)
    {
        $points = $request->input('points');
        $uniqueId = $this->pointsService->cachePendingPoints($points);

        return response()->json([
            'message' => 'Зарегистрируйтесь или войдите, чтобы получить свои баллы.',
            'unique_id' => $uniqueId,
        ], 200);
    }
}
