<?php

namespace Database\Factories;

use App\Models\RecordCategory;
use App\Models\RecordType;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RecordTypeFactory extends Factory
{
    protected $model = RecordType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'base_weight' => $this->faker->randomFloat(),
            'notes' => $this->faker->word(),

            'record_category_id' => RecordCategory::factory(),
            'tenant_id' => Filament::getTenant()?->id,
        ];
    }
}
