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
    public function handle(Request $request, Closure $next)
    {
        // REVIEW - Tu platí to isté čo som písal do RegisterMiddleware.php

        $UserQuery = User::where("username", $request["username"])->first();

        if (!$UserQuery) {
            throw new Exception("User doesnt exist",400);
        }

        if (!Hash::check($request["password"], $UserQuery->password)) {
            throw new Exception("Incorrect password",400);
        }

        return $next($request);
    }
}