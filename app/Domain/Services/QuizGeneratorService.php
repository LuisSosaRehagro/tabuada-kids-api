<?php

namespace App\Domain\Services;

class QuizGeneratorService
{
    public function generate(int $tableNumber): array
    {
        $multipliers = range(1, 10);
        shuffle($multipliers);

        return array_map(
            fn($m) => $this->buildQuestion($tableNumber, $m),
            $multipliers
        );
    }

    private function buildQuestion(int $table, int $multiplier): array
    {
        $correct = $table * $multiplier;
        $wrong   = $this->generateWrongOptions($table, $multiplier, $correct);
        $options = array_merge([$correct], $wrong);
        shuffle($options);

        return [
            'question' => "{$table} × {$multiplier}",
            'correct'  => $correct,
            'options'  => $options,
        ];
    }

    private function generateWrongOptions(int $table, int $multiplier, int $correct): array
    {
        $candidates = [];

        foreach ([-2, -1, 1, 2] as $offset) {
            $m = $multiplier + $offset;
            if ($m >= 1 && $m <= 10) {
                $val = $table * $m;
                if ($val !== $correct) {
                    $candidates[] = $val;
                }
            }
        }

        // Se não houver candidatos suficientes (ex: tabuada do 1), use valores de outras tabuadas
        if (count($candidates) < 3) {
            foreach ([3, 5, 7] as $altTable) {
                $val = $altTable * $multiplier;
                if ($val !== $correct && !in_array($val, $candidates)) {
                    $candidates[] = $val;
                }
            }
        }

        $candidates = array_unique($candidates);
        shuffle($candidates);

        return array_slice($candidates, 0, 3);
    }
}
