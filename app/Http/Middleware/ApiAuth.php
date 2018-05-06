<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        config(['auth.defaults.guard' => 'dmobi']);

        if (auth()->guard('dmobi')->check() && auth()->guard('dmobi')->user()) {
            if (auth()->guard('dmobi')->user()->status == 'suspended') {
                return response()
                    ->json([
                        'status' => false,
                        'message' => '401 Unauthorized! Account is no longer active.',
                        'error_code' => 401,
                    ], 200);
            }
            return $next($request);
        }

        return response()
            ->json([
                'status' => false,
                'message' => '401 Unauthorized!',
                'error_code' => 401,
            ], 401);
    }
}
