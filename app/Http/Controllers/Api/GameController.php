<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GameResource;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
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
}
