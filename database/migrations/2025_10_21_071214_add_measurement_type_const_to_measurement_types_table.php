<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('measurement_types', function (Blueprint $table) {
            $table
                ->string('measurement_type')
                ->nullable()
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('measurement_types', function (Blueprint $table) {
            $table->dropColumn('measurement_type');
        });
    }
};
