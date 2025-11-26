<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Weight;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class WeightFactory extends Factory
{
    protected $model = Weight::class;

    public function definition(): array
    {
        return [
            'weight' => $this->faker->randomNumber(),
            'measured_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => auth()->user()?->id ?? User::factory(),
            'tenant_id' => Filament::getTenant()->id,
        ];
    }
}
