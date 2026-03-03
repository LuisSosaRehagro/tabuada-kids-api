<?php

namespace App\Domain\Ports\Repositories;

use App\Domain\Entities\Session;

interface SessionRepositoryInterface
{
    public function save(array $data): Session;
    public function getProgressByChild(string $childId): array;
}
