<?php

namespace Database\Factories;

use App\Models\RecordSet;
use App\Models\RecordType;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RecordSetFactory extends Factory
{
    protected $model = RecordSet::class;

    public function definition(): array
    {
        return [
            'set_done_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'record_type_id' => RecordType::factory(),
            'user_id' => User::factory(),
            'tenant_id' => Filament::getTenant()->id,
        ];
    }
}
