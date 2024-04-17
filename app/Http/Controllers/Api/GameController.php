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
     *     path="/api/games/{id}/finish",
     *     summary="Finish a game and generate a QR code",
     *     description="Finish a game, cache the points, generate a unique ID and a QR code based on this ID, and return the QR code as a data URI in a JSON response.",
     *     operationId="finishGame",
     *     tags={"Games"},
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="points",
     *                     type="integer",
     *                     description="The points earned in the game"
     *                 ),
     *                 example={"points": 123}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="A message instructing the user to register to receive the results"
     *                 ),
     *                 @OA\Property(
     *                     property="qr_code",
     *                     type="string",
     *                     description="The QR code as a data URI"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function finishGame(Request $request)
    {
        $points = $request->input('points');
        $uniqueId = $this->pointsService->cachePendingPoints($points);

        $qrCode = QrCode::create($uniqueId)->setSize(300)
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $qrCodeUri = $result->getDataUri();

        return response()->json([
            'message' => 'Зарегистрируйтесь в системе, чтобы получить результаты. Отсканируйте QR-код для перехода к регистрации',
            'qr_code' => $qrCodeUri
        ], 200);
    }
}
