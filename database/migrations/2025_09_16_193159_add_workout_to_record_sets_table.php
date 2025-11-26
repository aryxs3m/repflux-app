<?php

use App\Models\Workout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('record_sets', function (Blueprint $table) {
            $table->foreignIdFor(Workout::class)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('record_sets', function (Blueprint $table) {
            $table->dropForeignIdFor(Workout::class);
        });
    }
};
