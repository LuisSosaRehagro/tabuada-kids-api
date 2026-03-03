<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\SessionResultDTO;
use App\Application\UseCases\Session\SaveSessionResultUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class SessionController extends Controller
{
    public function __construct(
        private readonly SaveSessionResultUseCase $saveSession,
    ) {}

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'mode'            => 'required|in:study,play',
            'table_number'    => 'required|integer|between:1,10',
            'correct_answers' => 'required|integer|min:0|max:10',
            'total_questions' => 'required|integer|min:1|max:10',
        ]);

        $childId = JWTAuth::parseToken()->getPayload()->get('sub');

        $result = $this->saveSession->execute(new SessionResultDTO(
            childId:        $childId,
            mode:           $request->mode,
            tableNumber:    $request->table_number,
            correctAnswers: $request->correct_answers,
            totalQuestions: $request->total_questions,
        ));

        return response()->json($result, 201);
    }
}
