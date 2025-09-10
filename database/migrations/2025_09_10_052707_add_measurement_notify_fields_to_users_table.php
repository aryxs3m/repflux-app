<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notify_measurement_weight')->default(true)->index();
            $table->boolean('notify_measurement_body')->default(true)->index();
            $table->unsignedInteger('notify_measurement_body_days')->default(30);
            $table->unsignedInteger('notify_measurement_weight_days')->default(30);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('notify_measurement_weight');
            $table->dropColumn('notify_measurement_body');
            $table->dropColumn('notify_measurement_weight_days');
            $table->dropColumn('notify_measurement_body_days');
        });
    }
};
