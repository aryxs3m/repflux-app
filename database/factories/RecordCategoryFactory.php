<?php

namespace Database\Factories;

use App\Models\RecordCategory;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RecordCategoryFactory extends Factory
{
    protected $model = RecordCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'tenant_id' => Filament::getTenant()->id,
        ];
    }
}
