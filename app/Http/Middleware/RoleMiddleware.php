<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles   // Ruxsat berilgan rollar
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized ❌'
            ], 401);
        }

        $userRole = $user->role->name ?? null;

        if (!in_array($userRole, $roles)) {
            return response()->json([
                'status' => false,
                'message' => 'Access denied ❌'
            ], 403);
        }

        return $next($request);
    }
}
