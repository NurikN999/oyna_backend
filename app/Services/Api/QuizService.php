<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Option;
use App\Models\QuizQuestion;

class QuizService
{
    private ImageService $imageService;

    public function __construct(ImageService $imageServices)
    {
        $this->imageService = $imageServices;
    }

    public function createQuizQuestion(array $data): QuizQuestion
    {
        $quizQuestion = new QuizQuestion();
        $quizQuestion->text = $data['text'];
        $quizQuestion->game_id = $data['game_id'];
        $quizQuestion->save();

        return $quizQuestion;
    }

    public function createOptions(QuizQuestion $quizQuestion, array $options): void
    {
        foreach ($options as $option) {
            $createdOption = $quizQuestion->options()->create([
                'text' => $option['text'],
                'quiz_question_id' => $quizQuestion->id,
                'is_correct' => $option['is_correct'],
            ]);

            if ($option['image']) {
                $this->imageService->upload($option['image'], Option::class, $createdOption->id);
            }
        }
    }

}
