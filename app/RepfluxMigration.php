<?php

namespace App;

use App\Filament\Resources\RecordTypeResource\CardioMeasurement;
use App\Filament\Resources\RecordTypeResource\CardioMeasurementType;
use Exception;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Fluent;

abstract class RepfluxMigration extends Migration
{
    /**
     * @throws Exception
     */
    protected function addCardioField(Blueprint $table, CardioMeasurement $measurement, bool $update = false): ColumnDefinition
    {
        $columnDefinition = null;

        if ($measurement->getMeasurementType() === CardioMeasurementType::INTEGER) {
            $columnDefinition = $table->unsignedInteger($measurement->getFieldName())->nullable();
        }

        if ($measurement->getMeasurementType() === CardioMeasurementType::FLOAT) {
            $columnDefinition = $table->float($measurement->getFieldName())->nullable();
        }

        if ($columnDefinition === null) {
            throw new Exception(sprintf('Unknown measurement type: %s', $measurement->getMeasurementType()->name));
        }

        if ($update) {
            $columnDefinition->change();
        }

        return $columnDefinition;
    }

    protected function dropCardioField(Blueprint $table, CardioMeasurement $measurement): Fluent
    {
        return $table->dropColumn($measurement->getMeasurementType());
    }
}
