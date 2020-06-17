<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class UserHasPermission
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

    public function handle($request, Closure $next, $permissions)
    {
        if ($this->auth->check()) {
            if (!$this->auth->user()->permissions($permissions)) {
                if ($request->ajax()) {
                    return response('Unauthorized.', 403);
                }
    
                abort(403, 'Unauthorized action.');
            }
        } else {
            $guest = Role::whereSlug('guest')->first();
    
            if ($guest) {
                if (!$guest->can($permissions)) {
                    if ($request->ajax()) {
                        return response('Unauthorized.', 403);
                    }
    
                    abort(403, 'Unauthorized action.');
                }
            }
        }
    
        return $next($request);
    }
}
