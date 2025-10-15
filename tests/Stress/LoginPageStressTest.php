<?php

use function Pest\Stressless\stress;

it('performs 10 login page loads within 5 seconds', function () {
    $this->actingAsGuest();

    $result = stress('http://localhost/app/login')
        ->concurrency(10)
        ->duration(5)
        ->run();

    expect($result->requests()->duration()->med())->toBeLessThan(1000)
        ->and($result->requests()->failed()->count())->toBe(0);
});
