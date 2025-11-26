<?php

namespace App\Http\Controllers;

use App\Filament\Resources\RecordSetResource\Pages\CreateRecordSet;
use App\Filament\Resources\WeightResource\Pages\CreateWeight;
use App\Models\Tenant;

class PwaShortcutController extends Controller
{
    protected function getFirstTenant(): Tenant
    {
        return auth()->user()->tenants()->first();
    }

    public function newWeightMeasurement()
    {
        return redirect(CreateWeight::getUrl(['tenant' => $this->getFirstTenant()]));
    }

    public function newRecordSet()
    {
        return redirect(CreateRecordSet::getUrl(['tenant' => $this->getFirstTenant()]));
    }
}
