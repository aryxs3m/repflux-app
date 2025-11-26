<?php

namespace Feature;

use App\Models\RecordSet;
use App\Models\Workout;
use Tests\TestCase;

class WorkoutServiceTest extends TestCase
{
    public function test_can_create_workout_automatically()
    {
        $recordSet = RecordSet::factory()->create();
        $this->assertDatabaseCount('workouts', 1);
        $workout = Workout::first();
        $this->assertEquals($workout->id, $recordSet->workout->id);
        $this->assertNotNull($workout->calc_total_weight);
        $this->assertNotNull($workout->calc_total_reps);
        $this->assertNotNull($workout->calc_total_exercises);
        $this->assertNotNull($workout->calc_dominant_category);
    }

    /*    public function test_can_automatically_update_workout_calculation()
        {
            $recordSet = RecordSet::factory()->create();
            $workout = Workout::first();

            $recordSet->records()->create([
                'weight' => 10,
                'repeat_count' => 10,
                'repeat_index' => 1,
            ]);

            $this->assertEquals(10, $workout->calc_total_weight);
            $this->assertEquals(10, $workout->calc_total_reps);
            $this->assertEquals(1, $workout->calc_total_exercises);
        }*/
}
