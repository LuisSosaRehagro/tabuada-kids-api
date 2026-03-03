<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCases\Progress\GetChildProgressUseCase;
use App\Domain\Ports\Repositories\ChildProfileRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProgressController extends Controller
{
    public function __construct(
        private readonly GetChildProgressUseCase        $getProgress,
        private readonly ChildProfileRepositoryInterface $childRepo,
    ) {}

    // GET /child/progress — criança vê seu próprio progresso
    public function childProgress(): JsonResponse
    {
        $childId  = JWTAuth::parseToken()->getPayload()->get('sub');
        $progress = $this->getProgress->execute($childId);

        return response()->json($this->formatProgress($progress));
    }

    // GET /parent/children/{id}/progress — pai vê progresso de um filho
    public function parentViewsChildProgress(string $childId): JsonResponse
    {
        $parentId = JWTAuth::parseToken()->getPayload()->get('sub');
        $child    = $this->childRepo->findById($childId);

        if (!$child || $child->parentId !== $parentId) {
            return response()->json(['message' => 'Filho não encontrado ou sem permissão.'], 403);
        }

        $progress = $this->getProgress->execute($childId);

        return response()->json([
            'child'    => ['id' => $child->id, 'nickname' => $child->nickname],
            'progress' => $this->formatProgress($progress),
        ]);
    }

    private function formatProgress(array $progress): array
    {
        return array_map(fn($p) => [
            'table_number'        => $p->tableNumber,
            'accuracy_percentage' => $p->accuracyPercentage,
            'status'              => $p->status,
            'total_sessions'      => $p->totalSessions,
        ], $progress);
    }
}
