<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class WorkoutFactory extends Factory
{
    protected $model = Workout::class;

    public function definition(): array
    {
        return [
            'workout_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'notes' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'calc_dominant_category' => random_int(5, 8),
            'calc_total_exercises' => random_int(1, 10),
            'calc_total_reps' => random_int(50, 700),
            'calc_total_weight' => random_int(200, 5000),

            'tenant_id' => Tenant::factory(),
        ];
    }
}
