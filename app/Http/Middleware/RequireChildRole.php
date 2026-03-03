<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class RequireChildRole
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            if ($payload->get('role') !== 'child') {
                return response()->json(['message' => 'Acesso não autorizado.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token inválido ou expirado.'], 401);
        }

        return $next($request);
    }
}
