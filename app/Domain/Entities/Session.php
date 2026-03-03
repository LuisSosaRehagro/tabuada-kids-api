<?php

namespace App\Domain\Entities;

final class Session
{
    public function __construct(
        public readonly string $id,
        public readonly string $childId,
        public readonly string $mode,
        public readonly int    $tableNumber,
        public readonly int    $correctAnswers,
        public readonly int    $totalQuestions,
        public readonly string $completedAt,
    ) {}
}
