<?php

namespace Tests;

use App\Models\Tenant;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create();

        /** @var Tenant $tenant */
        $tenant = Tenant::factory()->create();
        $tenant->users()->attach($user, [
            'is_admin' => 1,
        ]);

        $this->actingAs($user);
        Filament::setTenant($tenant);
    }
}
