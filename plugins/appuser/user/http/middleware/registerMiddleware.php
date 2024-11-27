<?php
namespace Appuser\User\Http\Middleware;

use Input;
use Closure;
use Illuminate\Http\Request;
use AppUser\User\Models\User;
use Exception;

class RegisterMiddleware
{
    /* REVIEW - Tento middleware v podstate slúži na kontrolu input parametrov 'username' a 'password', ale dá so to urobiť lepšie bez middleware :D
    Pozri si v OCMS docs 'Model rules', je to funkcionalita OCMS ktorá ti dovolí nastaviť aké field je 'required', či má nejakú dlžú 'max' / 'min', a pod...
    A potom pre fieldy ktoré sú required iba pri vytváraní, ako napr. heslo, môžeš použiť tzv. kontext, ktorý vyzerá nejako takto 'required:create', keď tak pozri docs */
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