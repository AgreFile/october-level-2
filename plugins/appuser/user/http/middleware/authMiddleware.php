<?php
namespace Appuser\User\Http\Middleware;

use Closure;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Appuser\User\Services\AuthService;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $tokenCookie = Cookie::get("token");

        if (!$tokenCookie) {
            Log::info("Empty token cookie");
            return response()->json(["error" => "not_logged_in"],401);
        }

        if (!AuthService::ValidateToken($tokenCookie)) {
            Log::info("Invalid token");
            return response()->json(["error" => "invalid_token"],401);
        }

        return $next($request);
    }
}