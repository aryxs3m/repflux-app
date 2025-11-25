<?php

it('can get status', function () {
    $this->get('/api/status')
        ->assertOk()
        ->assertJsonStructure([
            'name',
            'version',
        ]);
});
