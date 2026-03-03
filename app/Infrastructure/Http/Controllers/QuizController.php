<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCases\Quiz\GenerateQuizUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class QuizController extends Controller
{
    public function __construct(
        private readonly GenerateQuizUseCase $generateQuiz,
    ) {}

    public function show(int $tableNumber): JsonResponse
    {
        try {
            $quiz = $this->generateQuiz->execute($tableNumber);
            return response()->json($quiz);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
