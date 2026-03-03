<?php

namespace App\Application\UseCases\Child;

use App\Application\DTOs\CreateChildDTO;
use App\Domain\Entities\ChildProfile;
use App\Domain\Ports\Repositories\ChildProfileRepositoryInterface;

class CreateChildProfileUseCase
{
    public function __construct(
        private readonly ChildProfileRepositoryInterface $repository,
    ) {}

    public function execute(CreateChildDTO $dto): ChildProfile
    {
        return $this->repository->save([
            'parent_id'     => $dto->parentId,
            'nickname'      => $dto->nickname,
            'username'      => $dto->username,
            'password_hash' => bcrypt($dto->password),
        ]);
    }
}
