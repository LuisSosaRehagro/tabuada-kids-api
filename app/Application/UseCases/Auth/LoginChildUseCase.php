<?php

namespace App\Application\UseCases\Auth;

use App\Application\DTOs\LoginDTO;
use App\Domain\Ports\Repositories\ChildProfileRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginChildUseCase
{
    public function __construct(
        private readonly ChildProfileRepositoryInterface $repository,
    ) {}

    public function execute(LoginDTO $dto): array
    {
        $child = $this->repository->findByUsername($dto->identifier);

        if (!$child || !Hash::check($dto->password, $child->passwordHash)) {
            return ['error' => 'Credenciais inválidas.', 'status' => 401];
        }

        $token = JWTAuth::fromUser(
            \App\Models\ChildProfile::find($child->id)
        );

        return [
            'token' => $token,
            'user'  => [
                'id'       => $child->id,
                'nickname' => $child->nickname,
                'role'     => 'child',
            ],
        ];
    }
}
