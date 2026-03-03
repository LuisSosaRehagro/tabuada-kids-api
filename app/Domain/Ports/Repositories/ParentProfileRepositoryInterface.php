<?php

namespace App\Domain\Ports\Repositories;

use App\Domain\Entities\ParentProfile;

interface ParentProfileRepositoryInterface
{
    public function save(array $data): ParentProfile;
    public function findByEmail(string $email): ?ParentProfile;
    public function findById(string $id): ?ParentProfile;
}
