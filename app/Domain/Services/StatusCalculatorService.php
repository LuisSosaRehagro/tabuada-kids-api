<?php

namespace App\Domain\Services;

use App\Domain\ValueObjects\TableStatus;

class StatusCalculatorService
{
    public function calculate(float $accuracyPercentage): TableStatus
    {
        return match(true) {
            $accuracyPercentage >= 80.0 => TableStatus::PRO,
            $accuracyPercentage >= 50.0 => TableStatus::ESTUDANTE,
            default                     => TableStatus::INICIANTE,
        };
    }
}
