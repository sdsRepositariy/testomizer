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
    public function handle($request, Closure $next, ...$roles)
    {
        //user()->role retrived from relations defined in the User model
        $userRole = $request->user()->role->role;

        foreach ($roles as $role) {
            if ($userRole == $role) {
                return $next($request);
            }
        }

        return redirect('/');
    }
}
