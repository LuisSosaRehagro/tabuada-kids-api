<?php

namespace App\Application\UseCases\Quiz;

use App\Domain\Services\QuizGeneratorService;
use App\Domain\ValueObjects\TableNumber;

class GenerateQuizUseCase
{
    public function __construct(
        private readonly QuizGeneratorService $generator,
    ) {}

    public function execute(int $tableNumber): array
    {
        $table = new TableNumber($tableNumber);

        return [
            'table_number' => $table->value,
            'questions'    => $this->generator->generate($table->value),
        ];
    }
}
