<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || ! in_array($request->user()->role, ['admin','moderator'])) {
            return redirect()->route('AcessoNegado.notice');
        }

        return $next($request);
    }
}