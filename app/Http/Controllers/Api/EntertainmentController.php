<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntertainmentRequest\EntertainmentStoreRequest;
use App\Http\Requests\EntertainmentRequest\EntertainmentUpdateRequest;
use App\Http\Resources\Api\EntertainmentResource;
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

    public function index()
    {
        $entertainments = Entertainment::paginate(4);

        return EntertainmentResource::collection($entertainments);
    }

    public function show(Entertainment $entertainment)
    {
        return response()->json([
            'data' => new EntertainmentResource($entertainment)
        ]);
    }

    public function update(EntertainmentUpdateRequest $request, Entertainment $entertainment)
    {
        $data = $request->validated();

        $entertainment->update($data);

        return response()->json([
            'message' => 'Entertainment updated successfully',
            'data' => new EntertainmentResource($entertainment)
        ]);
    }

    public function destroy(Entertainment $entertainment)
    {
        $entertainment->delete();

        return response()->json([
            'message' => 'Entertainment deleted successfully'
        ]);
    }

}
