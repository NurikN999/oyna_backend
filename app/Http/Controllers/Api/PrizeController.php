<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrizeRequests\StorePrizeRequest;
use App\Http\Requests\PrizeRequests\UpdatePrizeRequest;
use App\Http\Resources\Api\PrizeResource;
use App\Models\Prize;
use App\Services\Api\ImageService;

class PrizeController extends Controller
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @OA\Get(
     *    path="/api/prizes",
     *   summary="Get all prizes",
     *  description="Get all prizes",
     * operationId="getPrizes",
     * tags={"Prizes"},
     * security={{"bearerAuth": {}}},
     * @OA\Response(
     *    response=200,
     *  description="Success",
     * @OA\JsonContent(
     *   @OA\Property(
     *     property="data",
     *  type="array",
     * @OA\Items(ref="#/components/schemas/PrizeResource")
     * )
     * )
     * )
     * )
     */
    public function index()
    {
        $prizes = Prize::paginate(10);
        return PrizeResource::collection($prizes);
    }

    /**
     * @OA\Post(
     *     path="/api/prizes",
     *     summary="Create a new prize",
     *     description="Create a new prize and return the prize data",
     *     operationId="storePrize",
     *     tags={"Prizes"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Data for creating a new prize",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StorePrizeRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Prize created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PrizeResource")
     *     )
     * )
     */
    public function store(StorePrizeRequest $request)
    {
        $data = $request->validated();

        $prize = Prize::create($data);

        if ($request->hasFile('image')) {
            $this->imageService->upload($request->file('image'), Prize::class, $prize->id);
        }

        return response()->json([
            'message' => 'Prize created successfully.',
            'data' => new PrizeResource($prize)
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/prizes/{id}",
     *     summary="Get a specific prize",
     *     description="Get a specific prize by its id",
     *     operationId="getPrizeById",
     *     tags={"Prizes"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the prize to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/PrizeResource")
     *     )
     * )
     */
    public function show(Prize $prize)
    {
        return response()->json([
            'data' => new PrizeResource($prize)
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/prizes/{id}",
     *     summary="Update a specific prize",
     *     description="Update a specific prize by its id",
     *     operationId="updatePrize",
     *     tags={"Prizes"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the prize to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Data for updating a prize",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdatePrizeRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Prize updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PrizeResource")
     *     )
     * )
     */
    public function update(UpdatePrizeRequest $request, Prize $prize)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($prize->image) {
                $this->imageService->delete($prize->image->id);
            }

            $this->imageService->upload($request->file('image'), Prize::class, $prize->id);
        }

        $prize->update($data);

        return response()->json([
            'message' => 'Prize updated successfully.',
            'data' => new PrizeResource($prize)
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/prizes/{id}",
     *     summary="Delete a specific prize",
     *     description="Delete a specific prize by its id",
     *     operationId="deletePrize",
     *     tags={"Prizes"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the prize to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Prize deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Prize deleted successfully"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(Prize $prize)
    {
        $prize->delete();
        return response()->json([
            'message' => 'Prize deleted successfully.'
        ], 200);
    }
}
