<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     *  @OA\Get(
     *      path="/api/cities",
     *      summary="Get all cities",
     *      tags={"City"},
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      @OA\JsonContent(
     *      @OA\Property(
     *          property="data",
     *          type="array",
     *      @OA\Items(ref="#/components/schemas/CityResource")
     *      )
     *    )
     * )
     * )
     */
    public function index()
    {
        return response()->json([
            'data' => CityResource::collection(City::all()),
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/cities/{city}",
     *      summary="Get city by id",
     *      tags={"City"},
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="city",
     *          in="path",
     *          description="City id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      @OA\JsonContent(
     *      @OA\Property(
     *          property="data",
     *          ref="#/components/schemas/CityResource"
     *      )
     *    )
     * )
     * )

     */
    public function show(City $city)
    {
        return response()->json([
            'data' => new CityResource($city),
        ]);
    }

}
