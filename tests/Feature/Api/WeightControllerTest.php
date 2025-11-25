<?php

use App\Models\Weight;
use App\Services\Settings\Tenant;

it('can get weights empty', function () {
    $this->get('/api/weight?tenant_id='.Tenant::getTenant()->id)
        ->assertOk()
        ->assertJsonCount(0, 'data');
});

it('can get weights list', function () {
    Weight::factory()->count(10)->create();

    $this->get('/api/weight?tenant_id='.Tenant::getTenant()->id)
        ->assertOk()
        ->assertJsonCount(10, 'data');
});

it('can store weight', function () {
    $this->post('/api/weight', [
            'tenant_id' => Tenant::getTenant()->id,
            'user_id' => auth()->id(),
            'weight' => 100,
        ])
        ->assertStatus(201)
        ->assertJsonFragment(['id' => 1]);

    $this->assertDatabaseHas('weights', [
        'weight' => 100,
    ]);
});
