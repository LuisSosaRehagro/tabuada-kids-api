<?php

namespace App\Application\DTOs;

final class CreateChildDTO
{
    public function __construct(
        public readonly string $parentId,
        public readonly string $nickname,
        public readonly string $username,
        public readonly string $password,
    ) {}
}
