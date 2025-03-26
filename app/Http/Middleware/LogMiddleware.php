<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('Middleware triggered. User:', [
            'user' => auth()->user(),
            'team' => $request->route('team'),
        ]);

        return $next($request);
    }
}

