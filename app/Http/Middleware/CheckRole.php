<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role1, $role2)
    {
        //user()->role retrived from relations defined in the User model
        $userRole = $request->user()->role->role;
        if ($userRole!=$role1 && $userRole!=$role2) {
            return redirect ('/');
        }

        return $next($request);
    }
}
