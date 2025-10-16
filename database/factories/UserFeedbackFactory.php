<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserFeedback;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserFeedbackFactory extends Factory
{
    protected $model = UserFeedback::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'message' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
