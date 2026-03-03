<?php

namespace App\Application\UseCases\Child;

use App\Domain\Ports\Repositories\ChildProfileRepositoryInterface;

class DeleteChildProfileUseCase
{
    public function __construct(
        private readonly ChildProfileRepositoryInterface $repository,
    ) {}

    public function execute(string $childId, string $parentId): bool
    {
        $child = $this->repository->findById($childId);

        if (!$child || $child->parentId !== $parentId) {
            return false;
        }

        $this->repository->delete($childId);
        return true;
    }
}
