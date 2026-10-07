<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRecipeAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->is_admin) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Please sign in with an administrator account to manage recipes.');
        }

        return $next($request);
    }
}
