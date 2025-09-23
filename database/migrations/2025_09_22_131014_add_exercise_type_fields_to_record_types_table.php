<?php

use App\Filament\Resources\RecordTypeResource\ExerciseType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('record_types', function (Blueprint $table) {
            $table->enum('exercise_type', array_map(function (UnitEnum $item) {
                return $item->value;
            }, ExerciseType::cases()))->default(ExerciseType::WEIGHT->value);

            $table->json('cardio_measurements')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('record_types', function (Blueprint $table) {
            $table->dropColumn('exercise_type');
            $table->dropColumn('cardio_measurements');
        });
    }
};
