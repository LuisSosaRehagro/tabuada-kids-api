<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\CreateChildDTO;
use App\Application\UseCases\Child\CreateChildProfileUseCase;
use App\Application\UseCases\Child\DeleteChildProfileUseCase;
use App\Application\UseCases\Child\ListChildrenUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChildProfileController extends Controller
{
    public function __construct(
        private readonly ListChildrenUseCase        $listChildren,
        private readonly CreateChildProfileUseCase  $createChild,
        private readonly DeleteChildProfileUseCase  $deleteChild,
    ) {}

    public function index(): JsonResponse
    {
        $parentId = JWTAuth::parseToken()->getPayload()->get('sub');
        $children = $this->listChildren->execute($parentId);

        return response()->json(array_map(fn($c) => [
            'id'         => $c->id,
            'nickname'   => $c->nickname,
            'username'   => $c->username,
            'created_at' => $c->createdAt,
        ], $children));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nickname'              => 'required|string|max:50',
            'username'              => 'required|string|max:50|unique:child_profiles,username',
            'password'              => 'required|string|min:4|confirmed',
        ]);

        $parentId = JWTAuth::parseToken()->getPayload()->get('sub');

        $child = $this->createChild->execute(new CreateChildDTO(
            parentId:  $parentId,
            nickname:  $request->nickname,
            username:  $request->username,
            password:  $request->password,
        ));

        return response()->json([
            'id'         => $child->id,
            'nickname'   => $child->nickname,
            'username'   => $child->username,
            'created_at' => $child->createdAt,
        ], 201);
    }

    public function destroy(string $id): JsonResponse
    {
        $parentId = JWTAuth::parseToken()->getPayload()->get('sub');

        $deleted = $this->deleteChild->execute($id, $parentId);

        if (!$deleted) {
            return response()->json(['message' => 'Filho não encontrado ou sem permissão.'], 404);
        }

        return response()->json(['message' => 'Perfil removido com sucesso.']);
    }
}
