<?php

namespace App\Application\UseCases\Auth;

use App\Application\DTOs\LoginDTO;
use App\Domain\Ports\Repositories\ParentProfileRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginParentUseCase
{
    public function __construct(
        private readonly ParentProfileRepositoryInterface $repository,
    ) {}

    public function execute(LoginDTO $dto): array
    {
        $parent = $this->repository->findByEmail($dto->identifier);

        if (!$parent || !Hash::check($dto->password, $parent->passwordHash)) {
            return ['error' => 'Credenciais inválidas.', 'status' => 401];
        }

        $token = JWTAuth::fromUser(
            \App\Models\ParentProfile::find($parent->id)
        );

        return [
            'token' => $token,
            'user'  => [
                'id'   => $parent->id,
                'name' => $parent->name,
                'role' => 'parent',
            ],
        ];
    }
}
