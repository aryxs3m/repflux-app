<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('record_sets', function (Blueprint $table) {
            $table->unsignedInteger('cardio_measurement_calories')->nullable();
            $table->unsignedInteger('cardio_measurement_time')->nullable();
            $table->unsignedInteger('cardio_measurement_distance')->nullable();
            $table->unsignedInteger('cardio_measurement_speed_distance')->nullable();
            $table->unsignedInteger('cardio_measurement_speed_rotation')->nullable();
            $table->unsignedInteger('cardio_measurement_climbed')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('record_sets', function (Blueprint $table) {
            $table->dropColumn('cardio_measurement_calories');
            $table->dropColumn('cardio_measurement_time');
            $table->dropColumn('cardio_measurement_distance');
            $table->dropColumn('cardio_measurement_speed_distance');
            $table->dropColumn('cardio_measurement_speed_rotation');
            $table->dropColumn('cardio_measurement_climbed');
        });
    }
};
