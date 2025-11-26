<?php

namespace Database\Seeders;

use App\Models\Measurement;
use App\Models\MeasurementType;
use App\Models\RecordSet;
use App\Models\RecordType;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Weight;
use App\Services\StarterData\StarterDataService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(StarterDataService $service): void
    {
        echo " Creating user...\n";
        $user = User::factory()->create([
            'name' => 'Demo User',
            'email' => config('app.demo.email'),
            'password' => \Hash::make(config('app.demo.password')),
            'height' => 168,
            'weight_target' => 72,
            'language' => 'en',
        ]);

        echo " Creating tenant...\n";
        $tenant = Tenant::factory()->create([
            'unit_type' => 'metric',
        ]);
        $tenant->users()->attach($user);
        echo " Seeding tenant default data...\n";
        $service->seed($tenant);

        // Create basic items
        echo " Seeding weight measurements...\n";
        $weight = 81;
        for ($i = 0; $i < 30; $i++) {
            Weight::query()->insert([
                'tenant_id' => $tenant->id,
                'user_id' => $user->id,
                'measured_at' => Carbon::now()->subWeeks($i),
                'weight' => $weight + $i + random_int(0, 1),
            ]);
        }

        echo " Seeding body measurements...\n";
        $measurements = MeasurementType::query()
            ->where('tenant_id', $tenant->id)
            ->get();
        foreach ($measurements as $measurement) {
            for ($i = 0; $i < 30; $i++) {
                $model = Measurement::factory()->make([
                    'user_id' => $user->id,
                    'measurement_type_id' => $measurement->id,
                    'measured_at' => Carbon::now()->subWeeks($i),
                ]);
                $model->tenant_id = $tenant->id;
                $model->save();
            }
        }

        echo " Seeding records...\n";
        $recordTypes = RecordType::query()->where('tenant_id', $tenant->id)->get();
        $baseWeight = 80;
        for ($j = 0; $j < 300; $j++) {
            if ($j % 15 === 0) {
                $baseWeight -= 1;
            }

            $recordSet = RecordSet::make([
                'user_id' => $user->id,
                'record_type_id' => $recordTypes->random()->id,
                'set_done_at' => Carbon::now()->subHours($j * 2),
            ]);
            $recordSet->tenant_id = $tenant->id;
            $recordSet->record_type_id = $recordTypes->random()->id;
            $recordSet->save();

            \DB::beginTransaction();
            for ($k = 0; $k < 4; $k++) {
                $recordSet->records()->create([
                    'repeat_index' => $k + 1,
                    'repeat_count' => 10 - $k,
                    'weight' => $baseWeight + ($k + 1),
                ]);
            }
            \DB::commit();
        }
    }
}
