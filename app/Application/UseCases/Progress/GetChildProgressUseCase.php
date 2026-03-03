<?php

namespace App\Application\UseCases\Progress;

use App\Application\DTOs\TableProgressDTO;
use App\Domain\Ports\Repositories\SessionRepositoryInterface;
use App\Domain\Services\StatusCalculatorService;

class GetChildProgressUseCase
{
    public function __construct(
        private readonly SessionRepositoryInterface $repository,
        private readonly StatusCalculatorService    $statusCalculator,
    ) {}

    public function execute(string $childId): array
    {
        $progressFromDb = $this->repository->getProgressByChild($childId);
        $progressMap    = collect($progressFromDb)->keyBy('table_number');

        $result = [];
        for ($table = 1; $table <= 10; $table++) {
            $row = $progressMap->get($table);

            $accuracy = $row ? (float) $row['accuracy_percentage'] : 0.0;
            $sessions = $row ? (int) $row['total_sessions'] : 0;
            $status   = $this->statusCalculator->calculate($accuracy);

            $result[] = new TableProgressDTO(
                tableNumber:        $table,
                accuracyPercentage: $accuracy,
                status:             $status->value,
                totalSessions:      $sessions,
            );
        }

        return $result;
    }
}
