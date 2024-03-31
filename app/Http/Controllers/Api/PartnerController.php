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

    public function index()
    {
        return PartnersResource::collection(Partner::paginate(4));
    }

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

    public function show(Partner $partner)
    {
        return response()->json([
            'data' => new PartnersResource($partner)
        ], 200);
    }

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

    public function delete(Partner $partner)
    {
        if ($partner->image) {
            $this->imageService->delete($partner->image->id);
        }

        $partner->delete();

        return response()->json([
            'message' => 'Partner deleted successfully.'
        ], 200);
    }

}
