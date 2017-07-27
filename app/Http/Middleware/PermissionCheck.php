<?php

namespace App\Http\Middleware;

use App\Http\Model\User;
use Closure;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next,$permission)
    {
     //   dd($request);
        $user = User::where('name',session('users.admin_name'))->first();
        if (! $user->can($permission)) {
            abort(403);
        }
        return $next($request);
    }
}
