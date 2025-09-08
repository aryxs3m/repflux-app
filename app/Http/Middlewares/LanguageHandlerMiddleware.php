<?php

namespace App\Http\Middlewares;

use App;
use Closure;
use Illuminate\Http\Request;

class LanguageHandlerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() && auth()->user()->language) {
            App::setLocale(auth()->user()->language);
        }

        return $next($request);
    }
}
