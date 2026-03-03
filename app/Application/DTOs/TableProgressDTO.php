<?php

namespace App\Application\DTOs;

final class TableProgressDTO
{
    public function __construct(
        public readonly int    $tableNumber,
        public readonly float  $accuracyPercentage,
        public readonly string $status,
        public readonly int    $totalSessions,
    ) {}
}
