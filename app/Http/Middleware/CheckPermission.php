<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PermissionService;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permissions)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $permissionService = app(PermissionService::class);
        $permList = explode('|', $permissions);

        foreach ($permList as $perm) {
            if ($permissionService->userHasPermission(Auth::user(), trim($perm))) {
                return $next($request);
            }
        }

        abort(403, 'No tienes permiso para realizar esta acción.');
    }
}
