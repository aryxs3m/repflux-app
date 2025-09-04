<?php

use App\Models\RecordCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('record_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(RecordCategory::class, 'record_category_id')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('record_types');
    }
};
