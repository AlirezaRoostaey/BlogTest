<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Console\View\Components\Mutators\EnsureDynamicContentIsHighlighted;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->user() || $request->user()->role !== UserRole::ADMIN->value) {

            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }

}
