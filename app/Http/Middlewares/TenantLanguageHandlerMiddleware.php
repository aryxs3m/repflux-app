<?php

namespace App\Http\Middlewares;

use App;
use App\Services\Settings\TenantSettings;
use Closure;
use Illuminate\Http\Request;

class TenantLanguageHandlerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (TenantSettings::getTenant()) {
            App::setLocale(TenantSettings::getTenant()->language);
        }

        return $next($request);
    }
}
