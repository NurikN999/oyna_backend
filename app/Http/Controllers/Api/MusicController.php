<?php

namespace App\Http\Controllers\Api;

use App\Enums\MusicGenreType;
use App\Http\Controllers\Controller;
use App\Http\Requests\MusicRequest\StoreMusicRequest;
use App\Http\Requests\MusicRequest\UpdateMusicRequest;
use App\Http\Resources\Api\MusicResource;
use App\Models\Music;
use App\Services\Api\ImageService;
use App\Services\Api\MusicService;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    private ImageService $imageService;
    private MusicService $musicService;

    public function __construct(ImageService $imageService, MusicService $musicService)
    {
        $this->imageService = $imageService;
        $this->musicService = $musicService;
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreMusicRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     * @OA\Post(
     *     path="/api/music",
     *     summary="Create a new music",
     *     description="Create a new music and return the music data",
     *     operationId="storeMusic",
     *     tags={"Music"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Data for creating a new music",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreMusicRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Music created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Music created successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/MusicResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Bad request"
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreMusicRequest $request)
    {
        $data = $request->validated();
        $path = $this->musicService->upload($request->file('file'), $data['title']);

        $music = Music::create(array_merge($data, ['path' => $path]));

        if ($request->hasFile('image')) {
            $this->imageService->upload($request->file('image'), Music::class, $music->id);
        }

        return response()->json([
            'message' => 'Music created successfully',
            'data' => new MusicResource($music)
        ], 201);
    }

    /**
    * @OA\Get(
    *     path="/api/music",
    *     summary="Get all music",
    *     description="Get all music",
    *     operationId="getMusic",
    *     tags={"Music"},
    *     security={{"bearerAuth": {}}},
    *     @OA\Response(
    *         response=200,
    *         description="Success",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *                 @OA\Items(ref="#/components/schemas/MusicResource")
    *             )
    *         )
    *     )
    * )
    */
    public function index()
    {
        $musics = Music::paginate(4);

        return MusicResource::collection($musics);
    }

    /**
     * @OA\Get(
     *     path="/api/music/{id}",
     *     summary="Get a specific music",
     *     description="Get a specific music by its id",
     *     operationId="getMusicById",
     *     tags={"Music"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the music to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/MusicResource")
     *     )
     * )
    */
    public function show(Music $music)
    {
        return response()->json([
            'data' => new MusicResource($music)
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/music/{id}",
     *     summary="Update a specific music",
     *     description="Update a specific music by its id",
     *     operationId="updateMusic",
     *     tags={"Music"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the music to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Data for updating a music",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateMusicRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Music updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MusicResource")
     *     )
     * )
     */
    public function update(UpdateMusicRequest $request, Music $music)
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $this->musicService->delete($music->path);
            $path = $this->musicService->upload($request->file('file'), $data['title']);
            $music->update(array_merge($data, ['path' => $path]));
        } else {
            $music->update($data);
        }

        if ($request->hasFile('image')) {
            $this->imageService->upload($request->file('image'), Music::class, $music->id);
        }

        return response()->json([
            'message' => 'Music updated successfully',
            'data' => new MusicResource($music)
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/music/{id}",
     *     summary="Delete a specific music",
     *     description="Delete a specific music by its id",
     *     operationId="deleteMusic",
     *     tags={"Music"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the music to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Music deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Music deleted successfully"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(Music $music)
    {
        $this->musicService->delete($music->path);
        $music->delete();

        return response()->json([
            'message' => 'Music deleted successfully'
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/music/genres",
     *     summary="Get all music genres",
     *     description="Get all music genres",
     *     operationId="getMusicGenres",
     *     tags={"Music"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/MusicGenreType")
     *             )
     *         )
     *     )
     * )
     */
    public function genres()
    {
        return response()->json([
            'data' => MusicGenreType::all()
        ]);
    }


}
