<?php

namespace Feature;

use App\Models\Tenant;
use App\Services\StarterData\StarterDataService;
use Filament\Facades\Filament;
use Tests\TestCase;

class StarterDataTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_can_seed_tenant(): void
    {
        /** @var Tenant $tenant */
        $tenant = Filament::getTenant();

        $this->assertDatabaseCount('measurement_types', 0);
        $this->assertDatabaseCount('record_categories', 0);
        $this->assertDatabaseCount('record_types', 0);

        app(StarterDataService::class)->seed($tenant);

        $this->assertDatabaseHas('measurement_types');
        $this->assertDatabaseHas('record_categories');
        $this->assertDatabaseHas('record_types');
    }
}
