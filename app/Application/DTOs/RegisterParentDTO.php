<?php

namespace App\Application\DTOs;

final class RegisterParentDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {}
}
