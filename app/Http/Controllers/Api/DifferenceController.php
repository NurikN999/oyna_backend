<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DifferenceRequests\StoreDifferenceRequest;
use App\Http\Requests\DifferenceRequests\UpdateDifferenceRequest;
use App\Http\Resources\Api\DifferenceResource;
use App\Models\Difference;
use App\Services\Api\CoordinateService;
use App\Services\Api\ImageService;

class DifferenceController extends Controller
{
    private CoordinateService $coordinateService;
    private ImageService $imageService;

    public function __construct(CoordinateService $coordinateService, ImageService $imageService)
    {
        $this->coordinateService = $coordinateService;
        $this->imageService = $imageService;
    }

    /**
     * @OA\Get(
     *     path="/differences",
     *     summary="Get all differences",
     *     tags={"Differences"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/DifferenceResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $differences = Difference::all();

        return response()->json(
            [
                'message' => 'Differences retrieved successfully',
                'data' => DifferenceResource::collection($differences),
            ],
            200
        );
    }

    /**
     * @OA\Post(
     *     path="/differences",
     *     summary="Create a new difference",
     *     tags={"Differences"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreDifferenceRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/DifferenceResource")
     *     )
     * )
     */
    public function store(StoreDifferenceRequest $request)
    {
        $data = $request->validated();
        $difference = Difference::create([
            'game_level' => $data['game_level'],
            'game_id' => $data['game_id'],
        ]);

        $this->coordinateService->saveCoordinates($difference, $data);

        foreach($data['images'] as $image) {
            $this->imageService->upload($image, Difference::class, $difference->id);
        }

        return response()->json(
            [
                'message' => 'Difference created successfully',
                'data' => new DifferenceResource($difference),
            ],
            201
        );
    }

    /**
     * @OA\Get(
     *     path="/differences/{id}",
     *     summary="Get a specific difference",
     *     tags={"Differences"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/DifferenceResource")
     *     )
     * )
     */
    public function show(Difference $difference)
    {
        return response()->json(
            [
                'message' => 'Difference retrieved successfully',
                'data' => new DifferenceResource($difference),
            ],
            200
        );
    }

    /**
     * @OA\Patch(
     *     path="/differences/{id}",
     *     summary="Update a specific difference",
     *     tags={"Differences"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateDifferenceRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Updated",
     *         @OA\JsonContent(ref="#/components/schemas/DifferenceResource")
     *     )
     * )
     */
    public function update(UpdateDifferenceRequest $request, Difference $difference)
    {
        $data = $request->validated();
        $difference->update([
            'game_level' => $data['game_level'],
        ]);

        $difference->coordinates()->delete();
        $this->coordinateService->saveCoordinates($difference, $data);

        return response()->json(
            [
                'message' => 'Difference updated successfully',
                'data' => new DifferenceResource($difference),
            ],
            200
        );
    }

    /**
     * @OA\Delete(
     *     path="/differences/{id}",
     *     summary="Delete a specific difference",
     *     tags={"Differences"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deleted"
     *     )
     * )
     */
    public function destroy(Difference $difference)
    {
        $difference->delete();

        return response()->json(
            [
                'message' => 'Difference deleted successfully',
            ],
            200
        );
    }
}
