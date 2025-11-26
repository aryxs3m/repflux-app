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

    protected Tenant $testTenant;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create();

        $this->testTenant = Tenant::factory()->create();
        $this->testTenant->users()->attach($user, [
            'is_admin' => true,
        ]);

        $this->actingAs($user);
        Filament::setTenant($this->testTenant);
    }
}
