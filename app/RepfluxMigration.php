<?php

namespace App;

use App\Filament\Resources\RecordTypeResource\CardioMeasurement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Fluent;

abstract class RepfluxMigration extends Migration
{
    protected function addCardioField(Blueprint $table, CardioMeasurement $measurement): ColumnDefinition
    {
        return $table->unsignedInteger('cardio_measurement_'.$measurement->value)->nullable();
    }

    protected function dropCardioField(Blueprint $table, CardioMeasurement $measurement): Fluent
    {
        return $table->dropColumn('cardio_measurement_'.$measurement->value);
    }
}
