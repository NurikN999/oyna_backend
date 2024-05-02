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
        $quizQuestion->game_id = 1;
        $quizQuestion->save();

        if (isset($data['image']) && $data['image']) {
            $this->imageService->upload($data['image'], QuizQuestion::class, $quizQuestion->id);
        }

        return $quizQuestion;
    }

    public function createOptions(QuizQuestion $quizQuestion, array $options): void
    {
        foreach ($options as $option) {
            $createdOption = $quizQuestion->options()->create([
                'text' => $option['text'],
                'quiz_question_id' => $quizQuestion->id,
                'is_correct' => $option['is_correct'] === "true" ? true : false,
            ]);
        }
    }

    public function updateQuizQuestion(QuizQuestion $quizQuestion, array $data): QuizQuestion
    {
        foreach ($data['options'] as $option) {
            $quizQuestion->options()->updateOrCreate(
                ['id' => $option['id']],
                [
                    'text' => $option['text'],
                    'is_correct' => $option['is_correct'] === "true" ? true : false,
                ]
            );
        }
        if (isset($data['image']) && $data['image']) {
            if ($quizQuestion->image) {
                $this->imageService->delete($quizQuestion->image);
            }
            $this->imageService->update($data['image'], QuizQuestion::class, $quizQuestion->id);
        }

        $quizQuestion->update($data);

        return $quizQuestion;
    }

    public function updateOptions(QuizQuestion $quizQuestion, array $options): void
    {
        foreach ($options as $option) {
            $quizQuestion->options()->updateOrCreate(
                ['id' => $option['id']],
                [
                    'text' => $option['text'],
                    'is_correct' => $option['is_correct'] === "true" ? true : false,
                ]
            );

            if (isset($option['image']) && $option['image']) {
                $this->imageService->upload($option['image'], Option::class, $option['id']);
            }
        }
    }

}
