<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('number_format_decimals')->default(2);
            $table->string('number_format_decimal_separator', 1)->default(',');
            $table->string('number_format_thousands_separator', 1)->default(' ');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('number_format_decimals');
            $table->dropColumn('number_format_decimal_separator');
            $table->dropColumn('number_format_thousands_separator');
        });
    }
};
