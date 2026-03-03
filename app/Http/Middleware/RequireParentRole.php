<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class RequireParentRole
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            if ($payload->get('role') !== 'parent') {
                return response()->json(['message' => 'Acesso não autorizado.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token inválido ou expirado.'], 401);
        }

        return $next($request);
    }
}
