<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('record_sets', function (Blueprint $table) {
            $table->unsignedInteger('time')->nullable()->comment('Measured time in seconds for TIME type RecordTypes');
        });
    }

    public function down(): void
    {
        Schema::table('record_sets', function (Blueprint $table) {
            $table->dropColumn('time');
        });
    }
};
