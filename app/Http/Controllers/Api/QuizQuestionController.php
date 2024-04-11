<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizQuestionRequests\StoreQuizQuestion;
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
        $quizQuestions = QuizQuestion::paginate(1);

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

}
