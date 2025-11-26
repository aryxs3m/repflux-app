<?php

use App\Models\RecordCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->foreignIdFor(RecordCategory::class, 'calc_dominant_category')
                ->comment('Calculated on updates')
                ->nullable();
            $table->float('calc_total_weight')
                ->comment('Calculated on updates')
                ->nullable();
            $table->unsignedInteger('calc_total_reps')
                ->comment('Calculated on updates')
                ->nullable();
            $table->unsignedInteger('calc_total_exercises')
                ->comment('Calculated on updates')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->dropForeignIdFor(RecordCategory::class, 'calc_dominant_category');
            $table->dropColumn('calc_total_weight');
            $table->dropColumn('calc_total_reps');
            $table->dropColumn('calc_total_exercises');
        });
    }
};
