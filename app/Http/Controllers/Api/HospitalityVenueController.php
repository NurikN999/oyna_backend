<?php

namespace App\Http\Controllers\Api;

use App\Enums\HospitalityVenueType;
use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalityVenueRequest\StoreHospitalityVenueRequest;
use App\Http\Requests\HospitalityVenueRequest\UpdateHospitalityVenue;
use App\Http\Resources\Api\HospitalityVenueResource;
use App\Models\HospitalityVenue;
use App\Services\Api\ImageService;
use Illuminate\Http\Request;

class HospitalityVenueController extends Controller
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $hospitalityVenues = HospitalityVenue::paginate(4);

        return HospitalityVenueResource::collection($hospitalityVenues);
    }

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

    public function show(HospitalityVenue $hospitalityVenue)
    {
        return response()->json([
            'data' => new HospitalityVenueResource($hospitalityVenue)
        ], 200);
    }

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

    public function types()
    {
        return response()->json([
            'data' => HospitalityVenueType::all()
        ], 200);
    }

}
