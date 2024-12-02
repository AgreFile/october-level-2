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
        return $next($request);
    }
}