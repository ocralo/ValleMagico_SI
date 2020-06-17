<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


class UserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next , $role)
    {
        if (! $this->auth->user()->hasRole($role)) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            return abort(401);
        }
        return $next($request);
    }
}
