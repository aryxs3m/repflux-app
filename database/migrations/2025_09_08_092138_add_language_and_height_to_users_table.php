<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('height')->nullable();
            $table->string('language')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('height');
            $table->dropColumn('language');
        });

        Schema::table('tenants', function (Blueprint $table) {
            $table->string('language')->nullable();
        });
    }
};
