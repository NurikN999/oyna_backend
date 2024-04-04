<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OfferResource;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/offers",
     * summary="Get offers",
     * description="Get offers",
     * operationId="showAllOffers",
     * tags={"Offers"},
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(
     * @OA\Property(
     * property="data",
     * type="array",
     * @OA\Items(ref="#/components/schemas/OfferResource")
     * )
     * )
     * )
     * )
     */
    public function index()
    {
        return OfferResource::collection(Offer::paginate(4));
    }

    /**
     * @OA\Post(
     *     path="/api/offers",
     *     summary="Create a new offer",
     *     description="Create a new offer and return the offer data",
     *     operationId="storeOffer",
     *     tags={"Offers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Data for creating a new offer",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Offer created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/OfferResource")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $offer = Offer::create($request->all());
        return response()->json([
            'message' => 'Offer created successfully.',
            'data' => new OfferResource($offer)
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/offers/{id}",
     *     summary="Get a specific offer",
     *     description="Get a specific offer by its id",
     *     operationId="getOfferById",
     *     tags={"Offers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the offer to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/OfferResource")
     *     )
     * )
     */
    public function show(Offer $offer)
    {
        return response()->json([
            'data' => new OfferResource($offer)
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/offers/{id}",
     *     summary="Update a specific offer",
     *     description="Update a specific offer by its id",
     *     operationId="updateOffer",
     *     tags={"Offers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the offer to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Data for updating an offer",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Offer updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/OfferResource")
     *     )
     * )
     */
    public function update(Request $request, Offer $offer)
    {
        $offer->update($request->all());
        return response()->json([
            'message' => 'Offer updated successfully.',
            'data' => new OfferResource($offer)
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/offers/{id}",
     *     summary="Delete a specific offer",
     *     description="Delete a specific offer by its id",
     *     operationId="deleteOffer",
     *     tags={"Offers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the offer to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Offer deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Offer deleted successfully"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return response()->json([
            'message' => 'Offer deleted successfully.'
        ], 200);
    }

}
