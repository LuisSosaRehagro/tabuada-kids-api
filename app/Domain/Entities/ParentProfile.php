<?php

namespace App\Domain\Entities;

final class ParentProfile
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $passwordHash,
        public readonly string $name,
        public readonly string $createdAt,
    ) {}
}
