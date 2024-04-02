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

    public function index()
    {
        $musics = Music::paginate(4);

        return MusicResource::collection($musics);
    }

    public function show(Music $music)
    {
        return response()->json([
            'data' => new MusicResource($music)
        ], 200);
    }

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

    public function destroy(Music $music)
    {
        $this->musicService->delete($music->path);
        $music->delete();

        return response()->json([
            'message' => 'Music deleted successfully'
        ], 200);
    }

    public function genres()
    {
        return response()->json([
            'data' => MusicGenreType::all()
        ]);
    }


}
