<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\LoginDTO;
use App\Application\DTOs\RegisterParentDTO;
use App\Application\UseCases\Auth\LoginChildUseCase;
use App\Application\UseCases\Auth\LoginParentUseCase;
use App\Application\UseCases\Auth\RegisterParentUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(
        private readonly RegisterParentUseCase $registerParent,
        private readonly LoginParentUseCase    $loginParent,
        private readonly LoginChildUseCase     $loginChild,
    ) {}

    public function registerParent(Request $request): JsonResponse
    {
        $request->validate([
            'name'                  => 'required|string|max:100',
            'email'                 => 'required|email|unique:parent_profiles,email',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        $parent = $this->registerParent->execute(new RegisterParentDTO(
            name:     $request->name,
            email:    $request->email,
            password: $request->password,
        ));

        $token = JWTAuth::fromUser(\App\Models\ParentProfile::find($parent->id));

        return response()->json([
            'token' => $token,
            'user'  => ['id' => $parent->id, 'name' => $parent->name, 'role' => 'parent'],
        ], 201);
    }

    public function loginParent(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $result = $this->loginParent->execute(new LoginDTO(
            identifier: $request->email,
            password:   $request->password,
        ));

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error']], $result['status']);
        }

        return response()->json($result);
    }

    public function loginChild(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $result = $this->loginChild->execute(new LoginDTO(
            identifier: $request->username,
            password:   $request->password,
        ));

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error']], $result['status']);
        }

        return response()->json($result);
    }

    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception) {
            // blacklist desabilitado — sem problema, cliente descarta o token
        }
        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}
