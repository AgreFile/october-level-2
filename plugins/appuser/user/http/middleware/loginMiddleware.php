<?php
namespace Appuser\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use AppUser\User\Models\User;
use Exception;
use Input;
use Hash;

class LoginMiddleware
{
    // REVIEW - Tu platí to isté čo som písal do RegisterMiddleware.php
    public function handle(Request $request, Closure $next)
    {
        if (User::where("username", $_REQUEST["username"])->get()->isEmpty()) {
            throw new Exception("User doesnt exist",400);
        }
        $UserQuery = User::where("username", Input::get("username"));

        if (!Hash::check(Input::get("password"), $UserQuery->get()[0]->password)) {
            throw new Exception("Incorrect password",400);
        }

        return $next($request);
    }
}