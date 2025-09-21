<?php

namespace Database\Factories;

use App\Models\Invite;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Random\RandomException;

class InviteFactory extends Factory
{
    protected $model = Invite::class;

    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'hash' => bin2hex(random_bytes(18)),
            'expires_at' => Carbon::now()->addDays(7),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'tenant_id' => Tenant::factory(),
        ];
    }
}
