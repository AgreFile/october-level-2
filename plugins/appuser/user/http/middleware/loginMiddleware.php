<?php
namespace Appuser\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use AppUser\User\Models\User;
use Input;
use Hash;

class LoginMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (User::where("username", $_REQUEST["username"])->get()->isEmpty()) {
            return response()->json(['error' => 'user_doesnt_exists'], 400);
        }
        $UserQuery = User::where("username", Input::get("username"));

        if (!Hash::check(Input::get("password"), $UserQuery->get()[0]->password)) {
            return response()->json(['error' => 'incorrect_password'], 400);
        }

        return $next($request);
    }
}