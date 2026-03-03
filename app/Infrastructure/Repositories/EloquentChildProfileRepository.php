<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\ChildProfile as ChildProfileEntity;
use App\Domain\Ports\Repositories\ChildProfileRepositoryInterface;
use App\Models\ChildProfile as ChildProfileModel;
use Illuminate\Support\Str;

class EloquentChildProfileRepository implements ChildProfileRepositoryInterface
{
    public function save(array $data): ChildProfileEntity
    {
        $model = ChildProfileModel::create(array_merge(['id' => Str::uuid()->toString()], $data));
        return $this->toEntity($model);
    }

    public function findByUsername(string $username): ?ChildProfileEntity
    {
        $model = ChildProfileModel::where('username', $username)->first();
        return $model ? $this->toEntity($model) : null;
    }

    public function findById(string $id): ?ChildProfileEntity
    {
        $model = ChildProfileModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findByParentId(string $parentId): array
    {
        return ChildProfileModel::where('parent_id', $parentId)
            ->get()
            ->map(fn($m) => $this->toEntity($m))
            ->toArray();
    }

    public function update(string $id, array $data): ChildProfileEntity
    {
        $model = ChildProfileModel::findOrFail($id);
        $model->update($data);
        return $this->toEntity($model->fresh());
    }

    public function delete(string $id): void
    {
        ChildProfileModel::findOrFail($id)->delete();
    }

    private function toEntity(ChildProfileModel $model): ChildProfileEntity
    {
        return new ChildProfileEntity(
            id:           $model->id,
            parentId:     $model->parent_id,
            nickname:     $model->nickname,
            username:     $model->username,
            passwordHash: $model->password_hash,
            createdAt:    (string) $model->created_at,
        );
    }
}
