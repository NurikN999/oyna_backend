<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => CityResource::collection(City::all()),
        ]);
    }

    public function show(Request $request, City $city)
    {
        return response()->json([
            'data' => new CityResource($city),
        ]);
    }

}
