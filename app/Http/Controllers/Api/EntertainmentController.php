<?php

namespace App\Http\Controllers\Api;

use App\Enums\EntertainmentType;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntertainmentRequest\EntertainmentStoreRequest;
use App\Http\Requests\EntertainmentRequest\EntertainmentUpdateRequest;
use App\Http\Resources\Api\EntertainmentResource;
use App\Models\Click;
use App\Models\Entertainment;
use App\Services\Api\ImageService;
use Illuminate\Http\Request;

class EntertainmentController extends Controller
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Store a newly created resource in storage.
     * @param EntertainmentStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @OA\Post(
     *    path="/api/entertainments",
     *   tags={"Entertainments"},
     *  summary="Store a newly created entertainment",
     * description="Store a newly created entertainment",
     * operationId="store",
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     *   required={"name", "description", "image", "city_id"},
     * @OA\Property(property="name", type="string", example="Entertainment name"),
     * @OA\Property(property="description", type="string", example="Entertainment description"),
     * @OA\Property(property="image", type="string", format="binary"),
     * @OA\Property(property="city_id", type="integer", example="1"),
     * )
     * ),
     * @OA\Response(
     *   response=201,
     * description="Entertainment created successfully",
     * @OA\JsonContent(
     *  @OA\Property(property="message", type="string", example="Entertainment created successfully"),
     * @OA\Property(property="data", type="object", ref="#/components/schemas/EntertainmentResource"),
     * )
     * ),
     * @OA\Response(
     *  response=422,
     * description="Validation error",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="The given data was invalid."),
     * )
     * )
     * )
     * )
     */
    public function store(EntertainmentStoreRequest $request)
    {
        $data = $request->validated();

        $entertainment = Entertainment::create($data);

        if ($request->hasFile('image')) {
            $image = $this->imageService->upload($request->file('image'), Entertainment::class, $entertainment->id);
        }

        return response()->json([
            'message' => 'Entertainment created successfully',
            'data' => new EntertainmentResource($entertainment)
        ], 201);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @OA\Get(
     *   path="/api/entertainments",
     * tags={"Entertainments"},
     * summary="Get all entertainments",
     * description="Get all entertainments",
     * operationId="index",
     * @OA\Response(
     *  response=200,
     * description="Entertainments retrieved successfully",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/EntertainmentResource")),
     * )
     * )
     * )
     */
    public function index()
    {
        $entertainments = Entertainment::paginate(10);

        return EntertainmentResource::collection($entertainments);
    }

    /**
     * Display the specified resource.
     * @param Entertainment $entertainment
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *  path="/api/entertainments/{entertainment}",
     * tags={"Entertainments"},
     * summary="Get entertainment by id",
     * description="Get entertainment by id",
     * operationId="show",
     * @OA\Parameter(
     * name="entertainment",
     * in="path",
     * description="Entertainment id",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Entertainment retrieved successfully",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="object", ref="#/components/schemas/EntertainmentResource"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Entertainment not found",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Entertainment not found"),
     * )
     * )
     * )
     */
    public function show(Entertainment $entertainment)
    {
        Click::create([
            'field_name' => $entertainment->title,
            'field_type' => 'entertainment',
            'field_id' => $entertainment->id,
            'click' => 1
        ]);

        return response()->json([
            'data' => new EntertainmentResource($entertainment)
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param EntertainmentUpdateRequest $request
     * @param Entertainment $entertainment
     * @return \Illuminate\Http\JsonResponse
     * @OA\Patch(
     * path="/api/entertainments/{entertainment}",
     * tags={"Entertainments"},
     * summary="Update entertainment by id",
     * description="Update entertainment by id",
     * operationId="update",
     * @OA\Parameter(
     * name="entertainment",
     * in="path",
     * description="Entertainment id",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name", "description", "image", "city_id"},
     * @OA\Property(property="name", type="string", example="Entertainment name"),
     * @OA\Property(property="description", type="string", example="Entertainment description"),
     * @OA\Property(property="image", type="string", format="binary"),
     * @OA\Property(property="city_id", type="integer", example="1"),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Entertainment updated successfully",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Entertainment updated successfully"),
     * @OA\Property(property="data", type="object", ref="#/components/schemas/EntertainmentResource"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Entertainment not found",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Entertainment not found"),
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation error",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="The given data was invalid."),
     * )
     * )
     * )
     */
    public function update(EntertainmentUpdateRequest $request, Entertainment $entertainment)
    {
        $data = $request->validated();

        $entertainment->update($data);

        return response()->json([
            'message' => 'Entertainment updated successfully',
            'data' => new EntertainmentResource($entertainment)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Entertainment $entertainment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @OA\Delete(
     * path="/api/entertainments/{entertainment}",
     * tags={"Entertainments"},
     * summary="Delete entertainment by id",
     * description="Delete entertainment by id",
     * operationId="destroy",
     * @OA\Parameter(
     * name="entertainment",
     * in="path",
     * description="Entertainment id",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Entertainment deleted successfully",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Entertainment deleted successfully"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Entertainment not found",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Entertainment not found"),
     * )
     * )
     * )
     */
    public function destroy(Entertainment $entertainment)
    {
        $entertainment->delete();

        return response()->json([
            'message' => 'Entertainment deleted successfully'
        ]);
    }

    /**
     * Get all entertainment types.
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *  path="/api/entertainments/types",
     *  tags={"Entertainments"},
     *  summary="Get all entertainment types",
     *  description="Get all entertainment types",
     *  operationId="types",
     *  @OA\Response(
     *      response=200,
     *      description="Entertainment types retrieved successfully",
     *      @OA\JsonContent(
     *          @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/EntertainmentType")),
     *      )
     *  )
     * )
     */
    public function types()
    {
        return response()->json([
            'data' => EntertainmentType::all()
        ]);
    }

}
