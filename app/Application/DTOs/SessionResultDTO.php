<?php

namespace App\Application\DTOs;

final class SessionResultDTO
{
    public function __construct(
        public readonly string $childId,
        public readonly string $mode,
        public readonly int    $tableNumber,
        public readonly int    $correctAnswers,
        public readonly int    $totalQuestions,
    ) {}
}
