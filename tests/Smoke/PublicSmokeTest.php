<?php

it('returns a successful response', function () {
    $this->actingAsGuest();

    $routes = [
        '/',
        '/app',
        '/app/login',
        '/app/register',
        '/app/password-reset/request',
        '/up',
    ];

    visit($routes)->assertNoSmoke();
});
