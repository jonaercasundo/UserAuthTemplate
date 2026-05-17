<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentMiddleware
{
    public function handle(Request $request, Closure $next, $department): Response
    {
        $user = auth()->user();

        if (!$user || !$user->department) {
            abort(403, 'Unauthorized - No Department Assigned');
        }

        if ($user->department->name !== $department) {
            abort(403, 'Unauthorized - Invalid Department');
        }

        return $next($request);
    }
}