<?php

namespace App\Domain\Entities;

final class ChildProfile
{
    public function __construct(
        public readonly string $id,
        public readonly string $parentId,
        public readonly string $nickname,
        public readonly string $username,
        public readonly string $passwordHash,
        public readonly string $createdAt,
    ) {}
}
