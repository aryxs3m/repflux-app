<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('record_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('record_type_id');
            $table->foreignId('user_id');
            $table->dateTime('set_done_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('record_sets');
    }
};
