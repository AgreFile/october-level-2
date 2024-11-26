<?php
namespace Appuser\User\Http\Middleware;

use Input;
use Closure;
use Illuminate\Http\Request;
use AppUser\User\Models\User;

class RegisterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (User::where("username", Input::get("username"))->get()->isNotEmpty()) {
            return response()->json(['error' => 'user_exists'], 400);
        }

        if (!ctype_alnum(Input::get("username"))) {
            return response()->json(['error' => 'username_not_alphanumeric'], 400);
        }

        if (!Input::get("password")) {
            return response()->json(['error' => 'invalid_password'], 400);
        }

        return $next($request);
    }
}