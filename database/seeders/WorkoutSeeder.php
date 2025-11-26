<?php

namespace Database\Seeders;

use App\Models\Workout;
use Illuminate\Database\Seeder;

class WorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workout::truncate();

        Workout::factory()->count(120)->create([
            'tenant_id' => 2,
        ]);
    }
}
