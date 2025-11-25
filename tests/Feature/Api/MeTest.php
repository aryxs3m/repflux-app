<?php

it('can get user', function () {
    $this->get('/api/me')
        ->assertOk();
});
