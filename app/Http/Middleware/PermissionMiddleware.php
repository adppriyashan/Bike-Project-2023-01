<?php

namespace App\Http\Middleware;

use App\Models\Permissions;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        error_log('test1');
        if (Auth::user()['status'] == '1') {
            if ((new Permissions)->isValid($request->getPathInfo())) {
                return $next($request);
            } else {
                return abort(403, 'Not permitted to access.');
            }
        } else {
            return abort(401, 'Your account is inactive.');
        }
    }
}
