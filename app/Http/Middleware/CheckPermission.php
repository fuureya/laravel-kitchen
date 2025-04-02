<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class CheckPermission
{

    // public function handle()
    // {
    //     if (in_array('view-dashboard', auth()->user()->permissions)) {
    //         dd('telaso');
    //     }
    // }

    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = auth()->user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $permissions = is_array($user->permissions) ? $user->permissions : json_decode($user->permissions ?? '[]', true);
        if (!in_array($permission, $permissions)) {
            abort(403, 'Tidak Ada Akses');
        }

        return $next($request);
    }
}
