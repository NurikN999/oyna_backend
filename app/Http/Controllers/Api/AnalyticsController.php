<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    private AnalyticsService $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * @OA\Get(
     *     path="/api/analytics",
     *     tags={"Analytics"},
     *     summary="Get analytics data",
     *     description="Get analytics data. You can filter the data by category by adding the 'category' query parameter. You can also filter the data by date by adding the 'date_from_gte' and 'date_to_lte' query parameters.",
     *     operationId="getAnalytics",
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="The category to filter the analytics data by",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="date_from_gte",
     *         in="query",
     *         description="The start date to filter the analytics data by",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="date-time"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="date_to_lte",
     *         in="query",
     *         description="The end date to filter the analytics data by",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="date-time"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Analytics data retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", description="The analytics data"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = $request->query('category', 'all');
        $dateFrom = $request->query('date_from_gte', null);
        $dateTo = $request->query('date_to_lte', null);

        $analyticsData = $this->analyticsService->getAnalytics($query, $dateFrom, $dateTo);

        return response()->json([
            'data' => $analyticsData,
        ]);
    }
}
