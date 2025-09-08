<?php

use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tables = [
        'record_categories',
        'record_types',
        'measurement_types',
        'measurements',
        'record_sets',
        'weights',
    ];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            try {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignIdFor(Tenant::class);
                });
            } catch (Throwable $e) {
                echo "Failed to add foreign key for tenant on table {$tableName}: ".$e->getMessage()."\n";
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            try {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeignIdFor(Tenant::class);
                });
            } catch (Throwable $e) {
                echo "Failed to drop foreign key for tenant on table {$tableName}: ".$e->getMessage()."\n";
                echo "\n";
            }
        }
    }
};
