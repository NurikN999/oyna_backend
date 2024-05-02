<?php

namespace App\Http\Controllers\Api;

use App\Enums\AdvertisingPlacementAreaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertisingRequest\StoreAdvertisingRequest;
use App\Http\Requests\AdvertisingRequest\UpdateAdvertisingRequest;
use App\Http\Resources\Api\AdvertisingResource;
use App\Models\Advertising;
use App\Services\Api\VideoService;
use Illuminate\Support\Facades\Storage;

class AdvertisingController extends Controller
{
    private VideoService $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @OA\Get(
     *    path="/api/advertisings",
     *   tags={"Advertisings"},
     *  summary="Get list of advertisings",
     * description="Get list of advertisings",
     * operationId="getAllAdvertisings",
     * @OA\Response(
     *   response=200,
     * description="List of advertisings",
     * @OA\JsonContent(
     *  @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/AdvertisingResource")),
     * )
     * )
     * )
     */
    public function index()
    {
        return AdvertisingResource::collection(Advertising::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreAdvertisingRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     *   path="/api/advertisings",
     *   tags={"Advertisings"},
     *   summary="Create advertising",
     *   description="Create advertising",
     *   operationId="storeAdvertising",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/StoreAdvertisingRequest")
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Advertising created successfully",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="data", type="object", ref="#/components/schemas/AdvertisingResource"),
     *     )
     *   )
     * )
     */
    public function store(StoreAdvertisingRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('video')) {
            $data['video_path'] = $this->videoService->upload($request->file('video'));
        } else {
            $data['video_path'] = $request->input('video_link');
        }

        $advertising = Advertising::create($data);

        return response()->json([
            'message' => 'Advertising created successfully',
            'data' => new AdvertisingResource($advertising)
        ], 201);
    }

    /**
     * Display the specified resource.
     * @param Advertising $advertising
     * @return AdvertisingResource
     * @OA\Get(
     *   path="/api/advertisings/{advertising}",
     *   tags={"Advertisings"},
     *   summary="Get advertising by id",
     *   description="Get advertising by id",
     *   operationId="showAdvertising",
     *   @OA\Parameter(
     *     name="advertising",
     *     in="path",
     *     description="Advertising id",
     *     required=true,
     *     @OA\Schema(
     *       type="integer",
     *       format="int64"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Advertising retrieved successfully",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", type="object", ref="#/components/schemas/AdvertisingResource"),
     *     )
     *   )
     * )
     */
    public function show(Advertising $advertising)
    {
        return new AdvertisingResource($advertising);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreAdvertisingRequest $request
     * @param Advertising $advertising
     * @return \Illuminate\Http\JsonResponse
     * @OA\Patch(
     *   path="/api/advertisings/{advertising}",
     *   tags={"Advertisings"},
     *   summary="Update advertising",
     *   description="Update advertising",
     *   operationId="updateAdvertising",
     *   @OA\Parameter(
     *     name="advertising",
     *     in="path",
     *     description="Advertising id",
     *     required=true,
     *     @OA\Schema(
     *       type="integer",
     *       format="int64"
     *     )
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/StoreAdvertisingRequest")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Advertising updated successfully",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *     )
     *   )
     * )
     */
    public function update(UpdateAdvertisingRequest $request, Advertising $advertising)
    {
        $data = $request->validated();

        if ($request->hasFile('video')) {
            Storage::disk('public')->delete($advertising->video_path);
            $data['video_path'] = $this->videoService->upload($request->file('video'));
        }

        if ($request->input('video_link')) {
            $data['video_path'] = $request->input('video_link');
        }

        $advertising->update($data);

        return response()->json([
            'message' => 'Advertising updated successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreAdvertisingRequest $request
     * @param Advertising $advertising
     * @return \Illuminate\Http\JsonResponse
     * @OA\Put(
     *   path="/api/advertisings/{advertising}",
     *   tags={"Advertisings"},
     *   summary="Update advertising",
     *   description="Update advertising",
     *   operationId="deleteAdvertising",
     *   @OA\Parameter(
     *     name="advertising",
     *     in="path",
     *     description="Advertising id",
     *     required=true,
     *     @OA\Schema(
     *       type="integer",
     *       format="int64"
     *     )
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/StoreAdvertisingRequest")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Advertising updated successfully",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *     )
     *   )
     * )
     */
    public function destroy(Advertising $advertising)
    {
        Storage::disk('public')->delete($advertising->video_path);
        $advertising->delete();

        return response()->json([
            'message' => 'Advertising deleted successfully'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/advertising/types",
     *     summary="Get all advertising placement area types",
     *     tags={"Advertising"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/AdvertisingPlacementAreaType")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *     ),
     * )
     */
    public function types()
    {
        return response()->json([
            'data' => AdvertisingPlacementAreaType::all()
        ]);
    }
}
