<?php

namespace Feature;

use App\Models\User;
use App\Services\Settings\Tenant;
use Tests\TestCase;

// TODO: fix in coverage report
class TenantSettingsService extends TestCase
{
    public function test_can_check_valid_administrators()
    {
        $this->assertTrue(Tenant::canAdminister(auth()->user()));
    }

    public function test_can_check_invalid_administrators()
    {
        $tenant = auth()->user()->tenants->first();
        $tenant->pivot->is_admin = false;
        $tenant->pivot->save();

        $this->assertFalse(Tenant::canAdminister(auth()->user()));
    }

    public function test_can_check_non_members()
    {
        $randomUser = User::factory()->create();

        $this->assertFalse(Tenant::canAdminister($randomUser));
    }

    public function test_can_format_number_with_suffix()
    {
        $formatted = Tenant::numberFormat(pi(), 'kg');

        $this->assertNotNull($formatted);
        $this->assertStringContainsString('kg', $formatted);
        $this->assertStringContainsString(' ', $formatted);
        $this->assertEquals('3,14 kg', $formatted);
    }

    public function test_can_format_number_without_suffix()
    {
        $formatted = Tenant::numberFormat(pi());

        $this->assertNotNull($formatted);
        $this->assertStringNotContainsString('kg', $formatted);
        $this->assertStringNotContainsString(' ', $formatted);
        $this->assertEquals('3,14', $formatted);
    }
}
