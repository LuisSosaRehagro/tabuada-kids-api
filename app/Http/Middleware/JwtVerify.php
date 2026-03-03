<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtVerify
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Apenas valida que o token existe e tem assinatura válida.
            // O carregamento do usuário fica para os middlewares de role.
            JWTAuth::parseToken()->checkOrFail();
        } catch (\Exception) {
            return response()->json(['message' => 'Token inválido ou expirado.'], 401);
        }

        return $next($request);
    }
}
