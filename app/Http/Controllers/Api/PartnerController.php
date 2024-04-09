<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnersRequest\StorePartnerRequest;
use App\Http\Requests\PartnersRequest\UpdatePartnerRequest;
use App\Http\Resources\Api\PartnersResource;
use App\Models\Partner;
use App\Services\Api\ImageService;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @OA\Get(
     *     path="/api/partners",
     *     summary="Get all partners",
     *     description="Get all partners",
     *     operationId="getPartners",
     *     tags={"Partners"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/PartnersResource")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return PartnersResource::collection(Partner::paginate(4));
    }

    /**
     * @OA\Post(
     *     path="/api/partners",
     *     summary="Create a new partner",
     *     description="Create a new partner and return the partner data",
     *     operationId="storePartner",
     *     tags={"Partners"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Data for creating a new partner",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StorePartnerRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Partner created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PartnersResource")
     *     )
     * )
     */
    public function store(StorePartnerRequest $request)
    {
        $data = $request->validated();

        $partner = Partner::create($data);

        if ($request->hasFile('image')) {
            $this->imageService->upload($request->file('image'), Partner::class, $partner->id);
        }

        return response()->json([
            'message' => 'Partner created successfully.',
            'data' => new PartnersResource($partner)
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/partners/{id}",
     *     summary="Get a specific partner",
     *     description="Get a specific partner by its id",
     *     operationId="getPartnerById",
     *     tags={"Partners"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the partner to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/PartnersResource")
     *     )
     * )
     */
    public function show(Partner $partner)
    {
        return response()->json([
            'data' => new PartnersResource($partner)
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/partners/{id}",
     *     summary="Update a specific partner",
     *     description="Update a specific partner by its id",
     *     operationId="updatePartner",
     *     tags={"Partners"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the partner to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Data for updating a partner",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdatePartnerRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Partner updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PartnersResource")
     *     )
     * )
     */
    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($partner->image) {
                $this->imageService->delete($partner->image->id);
            }

            $this->imageService->upload($request->file('image'), Partner::class, $partner->id);
        }

        $partner->update($data);

        return response()->json([
            'message' => 'Partner updated successfully.',
            'data' => new PartnersResource($partner)
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/partners/{id}",
     *     summary="Delete a specific partner",
     *     description="Delete a specific partner by its id",
     *     operationId="deletePartner",
     *     tags={"Partners"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the partner to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Partner deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Partner deleted successfully"
     *             )
     *         )
     *     )
     * )
     */
    public function delete(Partner $partner)
    {
        if ($partner->image) {
            $this->imageService->delete($partner->image);
        }

        $partner->delete();

        return response()->json([
            'message' => 'Partner deleted successfully.'
        ], 200);
    }

}
