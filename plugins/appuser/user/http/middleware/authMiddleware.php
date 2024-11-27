<?php
namespace Appuser\User\Http\Middleware;

use Closure;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Appuser\User\Services\AuthService;
use Exception;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $tokenCookie = Cookie::get("token");

        if (!$tokenCookie) {
            throw new Exception("Not logged in", 401);
        }

        if (!AuthService::ValidateToken($tokenCookie)) {
            throw new Exception("Invalid token", 401);
        }

        return $next($request);
    }
}