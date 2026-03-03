<?php

namespace App\Application\UseCases\Auth;

use App\Application\DTOs\RegisterParentDTO;
use App\Domain\Entities\ParentProfile;
use App\Domain\Ports\Repositories\ParentProfileRepositoryInterface;

class RegisterParentUseCase
{
    public function __construct(
        private readonly ParentProfileRepositoryInterface $repository,
    ) {}

    public function execute(RegisterParentDTO $dto): ParentProfile
    {
        return $this->repository->save([
            'name'          => $dto->name,
            'email'         => $dto->email,
            'password_hash' => bcrypt($dto->password),
        ]);
    }
}
