<?php
namespace Appuser\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegisterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}