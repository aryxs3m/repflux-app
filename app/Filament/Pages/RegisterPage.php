<?php

namespace App\Filament\Pages;

use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Auth\Pages\Register;

class RegisterPage extends Register
{
    use WithRateLimiting {
        WithRateLimiting::rateLimit as baseRateLimit;
    }

    protected function rateLimit($maxAttempts, $decaySeconds = 60, $method = null, $component = null): void
    {
        // set the *actual* $maxAttempts rate limit you want here
        $this->baseRateLimit(config('app.ratelimit.register'), $decaySeconds, $method, $component);
    }
}
