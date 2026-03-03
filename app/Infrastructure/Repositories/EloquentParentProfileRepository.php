<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\ParentProfile as ParentProfileEntity;
use App\Domain\Ports\Repositories\ParentProfileRepositoryInterface;
use App\Models\ParentProfile as ParentProfileModel;
use Illuminate\Support\Str;

class EloquentParentProfileRepository implements ParentProfileRepositoryInterface
{
    public function save(array $data): ParentProfileEntity
    {
        $model = ParentProfileModel::create(array_merge(['id' => Str::uuid()->toString()], $data));
        return $this->toEntity($model);
    }

    public function findByEmail(string $email): ?ParentProfileEntity
    {
        $model = ParentProfileModel::where('email', $email)->first();
        return $model ? $this->toEntity($model) : null;
    }

    public function findById(string $id): ?ParentProfileEntity
    {
        $model = ParentProfileModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    private function toEntity(ParentProfileModel $model): ParentProfileEntity
    {
        return new ParentProfileEntity(
            id:           $model->id,
            email:        $model->email,
            passwordHash: $model->password_hash,
            name:         $model->name,
            createdAt:    (string) $model->created_at,
        );
    }
}
