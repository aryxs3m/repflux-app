<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('records', function (Blueprint $table) {
            $table->float('weight')->change();
        });
    }

    public function down(): void
    {
        Schema::table('records', function (Blueprint $table) {
            $table->unsignedInteger('weight')->change();
        });
    }
};
