<?php

namespace App\Http\Controllers\Api;

use App\Enums\HospitalityVenueType;
use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalityVenueRequest\StoreHospitalityVenueRequest;
use App\Http\Requests\HospitalityVenueRequest\UpdateHospitalityVenue;
use App\Http\Resources\Api\HospitalityVenueResource;
use App\Models\HospitalityVenue;
use App\Services\Api\ImageService;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class HospitalityVenueController extends Controller
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
    * @OA\Get(
    *     path="/api/hospitality-venues",
    *     summary="Get all hospitality venues",
    *     description="Get all hospitality venues",
    *     operationId="getHospitalityVenues",
    *     tags={"Hospitality Venues"},
    *     security={{"bearerAuth": {}}},
    *     @OA\Response(
    *         response=200,
    *         description="Success",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *                 @OA\Items(ref="#/components/schemas/HospitalityVenueResource")
    *             )
    *         )
    *     )
    * )
    */
    public function index()
    {
        $hospitalityVenues = HospitalityVenue::paginate(10);

        return HospitalityVenueResource::collection($hospitalityVenues);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreHospitalityVenueRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     * path="/api/hospitality-venues",
     * summary="Create a new hospitality venue",
     * description="Create a new hospitality venue",
     * operationId="storeHospitalityAndVenue",
     * tags={"Hospitality Venues"},
     * security={{"bearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreHospitalityVenueRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Created",
     * @OA\JsonContent(
     * @OA\Property(
     * property="message",
     * type="string",
     * example="Venue created successfully."
     * ),
     * @OA\Property(
     * property="data",
     * ref="#/components/schemas/HospitalityVenueResource"
     * )
     * )
     * )
     * )
     */
    public function store(StoreHospitalityVenueRequest $request)
    {
        $data = $request->validated();

        $hospitalityVenue = HospitalityVenue::create($data);

        if ($request->hasFile('image')) {
            $this->imageService->upload($request->file('image'), HospitalityVenue::class, $hospitalityVenue->id);
        }

        return response()->json([
            'message' => 'Venue created successfully.',
            'data' => new HospitalityVenueResource($hospitalityVenue)
        ], 201);
    }

    /**
     * Display the specified resource.
     * @param HospitalityVenue $hospitalityVenue
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     * path="/api/hospitality-venues/{hospitalityVenueId}",
     * summary="Get a hospitality venue",
     * description="Get a hospitality venue",
     * operationId="showHospitalityAndVenue",
     * tags={"Hospitality Venues"},
     * security={{"bearerAuth": {}}},
     * @OA\Parameter(
     * name="hospitalityVenue",
     * in="path",
     * required=true,
     * description="ID of the hospitality venue",
     * @OA\Schema(
     * type="integer",
     * example="1"
     * )
     * ),
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="data",
     *              ref="#/components/schemas/HospitalityVenueResource"
     *          )
     *      )
     * )
     * )
     */
    public function show(HospitalityVenue $hospitalityVenue)
    {
        return response()->json([
            'data' => new HospitalityVenueResource($hospitalityVenue)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateHospitalityVenue $request
     * @param HospitalityVenue $hospitalityVenue
     * @return \Illuminate\Http\JsonResponse
     * @OA\Put(
     * path="/api/hospitality-venues/{hospitalityVenueId}",
     * summary="Update a hospitality venue",
     * description="Update a hospitality venue",
     * operationId="updateHospitalityAndVenue",
     * tags={"Hospitality Venues"},
     * security={{"bearerAuth": {}}},
     * @OA\Parameter(
     * name="hospitalityVenue",
     * in="path",
     * required=true,
     * description="ID of the hospitality venue",
     * @OA\Schema(
     * type="integer",
     * example="1"
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/UpdateHospitalityVenue")
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     * @OA\Property(
     * property="message",
     * type="string",
     * example="Venue updated successfully."
     * ),
     * @OA\Property(
     * property="data",
     * ref="#/components/schemas/HospitalityVenueResource"
     * )
     * )
     * )
     * )
     */
    public function update(UpdateHospitalityVenue $request, HospitalityVenue $hospitalityVenue)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($hospitalityVenue->image) {
                $this->imageService->delete($hospitalityVenue->image);
            }

            $this->imageService->upload($request->file('image'), HospitalityVenue::class, $hospitalityVenue->id);
        }

        $hospitalityVenue->update($data);

        return response()->json([
            'message' => 'Venue updated successfully.',
            'data' => new HospitalityVenueResource($hospitalityVenue)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param HospitalityVenue $hospitalityVenue
     * @return \Illuminate\Http\JsonResponse
     * @OA\Delete(
     * path="/api/hospitality-venues/{hospitalityVenueId}",
     * summary="Delete a hospitality venue",
     * description="Delete a hospitality venue",
     * operationId="deleteHospitalityAndVenue",
     * tags={"Hospitality Venues"},
     * security={{"bearerAuth": {}}},
     * @OA\Parameter(
     * name="hospitalityVenue",
     * in="path",
     * required=true,
     * description="ID of the hospitality venue",
     * @OA\Schema(
     * type="integer",
     * example="1"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     * @OA\Property(
     * property="message",
     * type="string",
     * example="Venue deleted successfully."
     * )
     * )
     * )
     * )
     */
    public function delete(HospitalityVenue $hospitalityVenue)
    {
        if ($hospitalityVenue->image) {
            $this->imageService->delete($hospitalityVenue->image);
        }

        $hospitalityVenue->delete();

        return response()->json([
            'message' => 'Venue deleted successfully.'
        ], 200);
    }

    /**
     * Get all hospitality venue types
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     * path="/api/hospitality-venues/types",
     * summary="Get all hospitality venue types",
     * description="Get all hospitality venue types",
     * operationId="getHospitalityVenueTypes",
     * tags={"Hospitality Venues"},
     * security={{"bearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     * @OA\Property(
     * property="data",
     * type="array",
     * @OA\Items(
     * @OA\Property(
     * property="id",
     * type="integer",
     * example="1"
     * ),
     * @OA\Property(
     * property="name",
     * type="string",
     * example="Hotel"
     * )
     * )
     * )
     * )
     * )
     * )
     */
    public function types()
    {
        return response()->json([
            'data' => HospitalityVenueType::all()
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/hospitality-venues/{hospitalityVenueId}/qr-code",
     *     summary="Get a QR code for a specific hospitality venue",
     *     description="Generate a QR code based on the address of the specified hospitality venue. The QR code is returned as a data URI in a JSON response.",
     *     operationId="showQrCode",
     *     tags={"Hospitality Venues"},
     *     @OA\Parameter(
     *         name="hospitalityVenueId",
     *         in="path",
     *         description="The ID of the hospitality venue for which to generate the QR code",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="qr_code",
     *                     type="string",
     *                     description="The QR code as a data URI"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hospitality venue not found"
     *     )
     * )
     */
    public function showQrCode(HospitalityVenue $hospitalityVenue)
    {
        $qrCode = QrCode::create($hospitalityVenue->address)
            ->setSize(300)
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $qrCodeUri = $result->getDataUri();

        return response()->json([
            'qr_code' => $qrCodeUri
        ]);
    }

}
