<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizQuestionRequests\StoreQuizQuestion;
use App\Http\Requests\QuizQuestionRequests\UpdateQuizQuestionRequest;
use App\Http\Resources\Api\QuizQuestionResource;
use App\Models\QuizQuestion;
use App\Services\Api\QuizService;
use Illuminate\Http\Request;

class QuizQuestionController extends Controller
{
    protected QuizService $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    /**
     * @OA\Get(
     *     path="/api/quiz-questions",
     *     summary="Get a list of quiz questions",
     *     description="Get a paginated list of quiz questions",
     *     operationId="getQuizQuestions",
     *     tags={"QuizQuestions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/QuizQuestionResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $quizQuestions = QuizQuestion::all();

        return response()->json([
            'data' => QuizQuestionResource::collection($quizQuestions),
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/quiz-questions",
     *     summary="Create a new quiz question",
     *     description="Create a new quiz question and its options",
     *     operationId="storeQuizQuestion",
     *     tags={"QuizQuestions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreQuizQuestion")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/QuizQuestionResource")
     *     )
     * )
     */
    public function store(StoreQuizQuestion $request)
    {
        $data = $request->validated();
        $quizQuestion = $this->quizService->createQuizQuestion($data);
        $this->quizService->createOptions($quizQuestion, $data['options']);

        return response()->json([
            'data' => new QuizQuestionResource($quizQuestion),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/quiz-questions/{quizQuestion}",
     *     summary="Get a quiz question",
     *     description="Get a quiz question by ID",
     *     operationId="getQuizQuestion",
     *     tags={"QuizQuestions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="quizQuestion",
     *         in="path",
     *         required=true,
     *         description="The ID of the quiz question",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/QuizQuestionResource")
     *     )
     * )
     */
    public function show(QuizQuestion $quizQuestion)
    {
        return response()->json([
            'data' => new QuizQuestionResource($quizQuestion),
        ], 200);
    }

    /**
     * @OA\Patch(
     *     path="/api/quiz-questions/{quizQuestion}",
     *     summary="Update a quiz question",
     *     description="Update a quiz question and its options",
     *     operationId="updateQuizQuestion",
     *     tags={"QuizQuestions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="quizQuestion",
     *         in="path",
     *         required=true,
     *         description="The ID of the quiz question",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateQuizQuestionRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/QuizQuestionResource")
     *     )
     * )
     */
    public function update(QuizQuestion $quizQuestion, UpdateQuizQuestionRequest $request)
    {
        $data = $request->validated();

        $updatedQuizQuestion = $this->quizService->updateQuizQuestion($quizQuestion, $data);
        $this->quizService->updateOptions($updatedQuizQuestion, $data['options']);

        return response()->json([
            'data' => new QuizQuestionResource($quizQuestion),
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/quiz-questions/{quizQuestion}",
     *     summary="Delete a quiz question",
     *     description="Delete a quiz question by ID",
     *     operationId="deleteQuizQuestion",
     *     tags={"QuizQuestions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="quizQuestion",
     *         in="path",
     *         required=true,
     *         description="The ID of the quiz question",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content"
     *     )
     * )
     */
    public function destroy(QuizQuestion $quizQuestion)
    {
        $quizQuestion->delete();

        return response()->json(null, 204);
    }

}
