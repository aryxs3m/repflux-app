<?php

namespace Database\Factories;

use App\Models\Measurement;
use App\Models\MeasurementType;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MeasurementFactory extends Factory
{
    protected $model = Measurement::class;

    public function definition(): array
    {
        return [
            'measured_at' => Carbon::now(),
            'value' => random_int(10, 20),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'measurement_type_id' => MeasurementType::factory(),
            'user_id' => User::factory(),
            'tenant_id' => Filament::getTenant()?->id,
        ];
    }
}
