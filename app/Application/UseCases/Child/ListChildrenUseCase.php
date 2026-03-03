<?php

namespace App\Application\UseCases\Child;

use App\Domain\Ports\Repositories\ChildProfileRepositoryInterface;

class ListChildrenUseCase
{
    public function __construct(
        private readonly ChildProfileRepositoryInterface $repository,
    ) {}

    public function execute(string $parentId): array
    {
        return $this->repository->findByParentId($parentId);
    }
}
