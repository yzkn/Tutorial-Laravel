<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\Authenticate;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
        Log::debug(sprintf('JWTAuthenticateRole::handle(%s, Closure, %s)', $request, $role));

        $this->authenticate($request);

        $user = $this->auth->parseToken()->user();

        // 設定値の確認
        // Log::debug(sprintf('JWTAuthenticateRole::handle() sysadmin: %s', Config::get('auth.role.sysadmin', 2)));

        // 権限チェック
        $is_authorized = false;
        if ($role == 'sysadmin' && $user['role'] == Config::get('auth.role.sysadmin', 2)) {
            $is_authorized = true;
        } elseif ($role == 'admin' && $user['role'] > 0 && $user['role'] < 10 * Config::get('auth.role.admin', 20)) {
            $is_authorized = true;
        } elseif ($role == 'general' && $user['role'] > 0 && $user['role'] < 10 * Config::get('auth.role.general', 200)) {
            $is_authorized = true;
        } elseif ($role == 'guest' && $user['role'] > 0 && $user['role'] < 10 * Config::get('auth.role.guest', 2000)) {
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
