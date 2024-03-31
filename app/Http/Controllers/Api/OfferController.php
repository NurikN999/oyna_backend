<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OfferResource;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{

    public function index()
    {
        return OfferResource::collection(Offer::paginate(4));
    }

    public function store(Request $request)
    {
        $offer = Offer::create($request->all());
        return response()->json([
            'message' => 'Offer created successfully.',
            'data' => new OfferResource($offer)
        ], 201);
    }

    public function show(Offer $offer)
    {
        return response()->json([
            'data' => new OfferResource($offer)
        ], 200);
    }

    public function update(Request $request, Offer $offer)
    {
        $offer->update($request->all());
        return response()->json([
            'message' => 'Offer updated successfully.',
            'data' => new OfferResource($offer)
        ], 200);
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return response()->json([
            'message' => 'Offer deleted successfully.'
        ], 200);
    }

}
