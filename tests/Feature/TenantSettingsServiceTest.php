<?php

namespace Feature;

use App\Models\User;
use App\Services\Settings\Tenant;
use App\Services\Settings\TenantSettingsService;
use Tests\TestCase;

class TenantSettingsServiceTest extends TestCase
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

    public function test_can_check_current_user()
    {
        $this->assertTrue(Tenant::canAdminister());
    }

    public function test_can_detach_user_from_tenant()
    {
        $user = User::factory()->create();
        $this->testTenant->users()->attach($user);
        $this->assertCount(2, $this->testTenant->users);

        Tenant::removeUser($user);

        $this->testTenant->refresh();
        $this->assertCount(1, $this->testTenant->users);
    }

    public function test_can_check_non_members()
    {
        $randomUser = User::factory()->create();

        $this->assertFalse(Tenant::canAdminister($randomUser));
    }

    public function test_can_return_string_when_trying_to_format()
    {
        $service = app(TenantSettingsService::class);

        $result = $service->numberFormat('string');
        $this->assertEquals('string', $result);
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
