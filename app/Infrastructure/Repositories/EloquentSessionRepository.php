<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Session as SessionEntity;
use App\Domain\Ports\Repositories\SessionRepositoryInterface;
use App\Models\Session as SessionModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EloquentSessionRepository implements SessionRepositoryInterface
{
    public function save(array $data): SessionEntity
    {
        $model = SessionModel::create(array_merge(['id' => Str::uuid()->toString()], $data));
        return $this->toEntity($model);
    }

    public function getProgressByChild(string $childId): array
    {
        $rows = DB::select("
            SELECT
                table_number,
                COUNT(*)                                                            AS total_sessions,
                SUM(correct_answers)                                                AS total_correct,
                SUM(total_questions)                                                AS total_questions_sum,
                ROUND(
                    SUM(correct_answers)::DECIMAL / NULLIF(SUM(total_questions), 0) * 100,
                    1
                )                                                                   AS accuracy_percentage
            FROM sessions
            WHERE child_id = ?
              AND mode = 'play'
            GROUP BY table_number
            ORDER BY table_number
        ", [$childId]);

        // DB::select() retorna stdClass; converte para array para acesso uniforme
        return array_map(fn($row) => (array) $row, $rows);
    }

    private function toEntity(SessionModel $model): SessionEntity
    {
        return new SessionEntity(
            id:             $model->id,
            childId:        $model->child_id,
            mode:           $model->mode,
            tableNumber:    $model->table_number,
            correctAnswers: $model->correct_answers,
            totalQuestions: $model->total_questions,
            completedAt:    (string) $model->completed_at,
        );
    }
}
