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
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized ❌ (token topilmadi)'
            ], 401);
        }

        // 🔹 Agar users jadvalida `role` ustuni string bo‘lsa
        $userRole = $user->role ?? null;

        // 🔹 Agar `role_id` bilan Role jadvali bo‘lsa:
        // $userRole = $user->role->name ?? null;

        if (!$userRole || !in_array($userRole, $roles)) {
            return response()->json([
                'status' => false,
                'message' => "Access denied ❌. Sizning rolingiz: " . ($userRole ?? 'yo‘q')
            ], 403);
        }

        return $next($request);
    }
}
