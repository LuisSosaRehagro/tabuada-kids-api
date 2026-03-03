<?php

namespace App\Application\DTOs;

final class LoginDTO
{
    public function __construct(
        public readonly string $identifier,
        public readonly string $password,
    ) {}
}
