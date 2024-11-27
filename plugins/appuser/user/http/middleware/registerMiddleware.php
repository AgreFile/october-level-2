<?php
namespace Appuser\User\Http\Middleware;

use Input;
use Closure;
use Illuminate\Http\Request;
use AppUser\User\Models\User;
use Exception;

class RegisterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (User::where("username", Input::get("username"))->get()->isNotEmpty()) {
            throw new Exception("User exists", 400);
        }

        if (!ctype_alnum(Input::get("username"))) {
            throw new Exception("user not alphanumeric", 400);
        }

        if (!Input::get("password")) {
            throw new Exception("invalid password", 400);
        }

        return $next($request);
    }
}