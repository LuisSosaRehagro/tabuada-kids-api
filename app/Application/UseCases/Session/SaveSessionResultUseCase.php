<?php

namespace App\Application\UseCases\Session;

use App\Application\DTOs\SessionResultDTO;
use App\Domain\Ports\Repositories\SessionRepositoryInterface;
use App\Domain\Services\StatusCalculatorService;
use App\Domain\ValueObjects\AccuracyRate;

class SaveSessionResultUseCase
{
    public function __construct(
        private readonly SessionRepositoryInterface $repository,
        private readonly StatusCalculatorService    $statusCalculator,
    ) {}

    public function execute(SessionResultDTO $dto): array
    {
        $session = $this->repository->save([
            'child_id'        => $dto->childId,
            'mode'            => $dto->mode,
            'table_number'    => $dto->tableNumber,
            'correct_answers' => $dto->correctAnswers,
            'total_questions' => $dto->totalQuestions,
        ]);

        // Recalcula o progresso acumulado da tabuada após salvar a sessão
        $progress = $this->repository->getProgressByChild($dto->childId);
        $tableProgress = collect($progress)
            ->firstWhere('table_number', $dto->tableNumber);

        $accuracyRate  = $tableProgress
            ? new AccuracyRate((float) $tableProgress['accuracy_percentage'])
            : AccuracyRate::fromFraction($dto->correctAnswers, $dto->totalQuestions);

        $status = $this->statusCalculator->calculate($accuracyRate->value);

        return [
            'session_id'          => $session->id,
            'table_number'        => $session->tableNumber,
            'correct_answers'     => $session->correctAnswers,
            'accuracy_percentage' => $accuracyRate->value,
            'status'              => $status->value,
            'completed_at'        => $session->completedAt,
        ];
    }
}
