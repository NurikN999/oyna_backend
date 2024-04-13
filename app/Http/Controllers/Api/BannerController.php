<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequests\StoreBannerRequest;
use App\Http\Requests\BannerRequests\UpdateBannerRequest;
use App\Http\Resources\Api\BannerResource;
use App\Models\Banner;
use App\Services\Api\ImageService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @OA\Get(
     *     path="/banners",
     *     summary="Get a list of banners",
     *     tags={"Banners"},
     *     @OA\Response(
     *         response=200,
     *         description="A paginated array of banners",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/BannerResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function index()
    {
        $banners = Banner::paginate(10);

        return BannerResource::collection($banners);
    }

    /**
     * @OA\Post(
     *     path="/banners",
     *     summary="Create a new banner",
     *     tags={"Banners"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreBannerRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Banner created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/BannerResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\AdditionalProperties(
     *                     type="array",
     *                     @OA\Items(type="string")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreBannerRequest $request)
    {
        $banner = Banner::create($request->validated());
        $this->imageService->upload($request->file('image'), Banner::class, $banner->id);

        return new BannerResource($banner);
    }

    /**
     * @OA\Get(
     *     path="/banners/{banner}",
     *     summary="Get a banner",
     *     tags={"Banners"},
     *     @OA\Parameter(
     *         name="banner",
     *         in="path",
     *         required=true,
     *         description="The ID of the banner",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The banner",
     *         @OA\JsonContent(ref="#/components/schemas/BannerResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Banner not found"
     *     )
     * )
     */
    public function show(Banner $banner)
    {
        return new BannerResource($banner);
    }

    /**
     * @OA\Patch(
     *     path="/banners/{banner}",
     *     summary="Update a banner",
     *     tags={"Banners"},
     *     @OA\Parameter(
     *         name="banner",
     *         in="path",
     *         required=true,
     *         description="The ID of the banner",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateBannerRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Banner updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/BannerResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Banner not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\AdditionalProperties(
     *                     type="array",
     *                     @OA\Items(type="string")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $data = $request->validated();
        $banner->update($data);

        if ($data['image']) {
            $this->imageService->delete($banner->image);
            $this->imageService->upload($request->file('image'), Banner::class, $banner->id);
        }

        return new BannerResource($banner);
    }

    /**
     * @OA\Delete(
     *     path="/banners/{banner}",
     *     summary="Delete a banner",
     *     tags={"Banners"},
     *     @OA\Parameter(
     *         name="banner",
     *         in="path",
     *         required=true,
     *         description="The ID of the banner",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Banner deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Banner not found"
     *     )
     * )
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return response()->json([
            'message' => 'Banner deleted successfully',
        ], 204);
    }

}
