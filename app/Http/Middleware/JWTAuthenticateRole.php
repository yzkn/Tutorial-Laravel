<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

class JWTAuthenticateRole extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role=null)
    {
        $this->authenticate($request);

        /*
        Role     Num
        sysadmin 1
        admin    10-99
        general  100-999
        guest    1000-9999
        */

        $user = $this->auth->parseToken()->user();
        // 要認証

        // 権限チェック
        $is_authorized = false;
        if ($role == 'sysadmin' && $user['role'] == 1) {
            $is_authorized = true;
        } elseif ($role == 'admin' && $user['role'] > 0 && $user['role'] < 100) {
            $is_authorized = true;
        } elseif ($role == 'general' && $user['role'] > 0 && $user['role'] < 1000) {
            $is_authorized = true;
        } elseif ($role == 'guest' && $user['role'] > 0 && $user['role'] < 10000) {
            $is_authorized = true;
        } elseif ($role == null) {
            $is_authorized = true;
        }

        if (!$is_authorized) {
            throw new UnauthorizedHttpException('jwt-auth', 'User role error.');
        }

        return $next($request);
    }
}
