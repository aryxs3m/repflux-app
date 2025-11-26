<?php

use App\Filament\Resources\RecordTypeResource\CardioMeasurement;
use App\RepfluxMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends RepfluxMigration
{
    public function up(): void
    {
        Schema::table('record_sets', function (Blueprint $table) {
            $this->addCardioField($table, CardioMeasurement::AVERAGE_STEPS);
        });
    }

    public function down(): void
    {
        Schema::table('record_sets', function (Blueprint $table) {
            $this->dropCardioField($table, CardioMeasurement::AVERAGE_STEPS);
        });
    }
};
