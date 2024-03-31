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

    public function index()
    {
        $prizes = Prize::paginate(4);
        return PrizeResource::collection($prizes);
    }

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

    public function show(Prize $prize)
    {
        return response()->json([
            'data' => new PrizeResource($prize)
        ], 200);
    }

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

    public function destroy(Prize $prize)
    {
        $prize->delete();
        return response()->json([
            'message' => 'Prize deleted successfully.'
        ], 200);
    }
}
