<?php

namespace App\Domain\Ports\Repositories;

use App\Domain\Entities\ChildProfile;

interface ChildProfileRepositoryInterface
{
    public function save(array $data): ChildProfile;
    public function findByUsername(string $username): ?ChildProfile;
    public function findById(string $id): ?ChildProfile;
    public function findByParentId(string $parentId): array;
    public function update(string $id, array $data): ChildProfile;
    public function delete(string $id): void;
}
