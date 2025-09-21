<?php

namespace App\Services;

use App\Services\Settings\Tenant;
use JetBrains\PhpStorm\NoReturn;

class PersonalRecordsService
{
    public function getRecords(): array
    {
        return \Cache::remember(sprintf('%d-%d-prs', Tenant::getTenant()->id, auth()->user()->id), 60, function () {
            $records = \DB::select('
            select record_type_id, MAX(weight) + record_types.base_weight as mweight
            from `records`
            inner join `record_sets` on `records`.`record_set_id` = `record_sets`.`id`
            inner join `record_types` on record_sets.record_type_id = record_types.id
            where `record_sets`.`user_id` = :user and `record_sets`.tenant_id = :tenant
            group by record_type_id', [
                'user' => auth()->user()->id,
                'tenant' => Tenant::getTenant()->id,
            ]);

            return array_column($records, 'mweight', 'record_type_id');
        });
    }
}
