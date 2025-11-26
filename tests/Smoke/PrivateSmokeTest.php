<?php

use App\Models\Measurement;
use App\Models\RecordSet;
use App\Models\Weight;

it('returns a successful response', function () {
    RecordSet::factory()->create();
    Weight::factory()->create();
    Measurement::factory()->create();

    $routes = [
        '/app/new',
        '/app/profile',
        '/app/1',
        '/app/1/profile',
        '/app/1/tenant-resources/users',
        '/app/1/calendar',
        '/app/1/workouts',
        '/app/1/workouts/view/1',
        '/app/1/workouts/1/edit',
        '/app/1/measurements',
        '/app/1/measurements/1/edit',
        '/app/1/measurements/create',
        '/app/1/record-sets',
        '/app/1/record-sets/view/1',
        '/app/1/record-sets/1/edit',
        '/app/1/record-sets/create',
        '/app/1/weights',
        '/app/1/weights/1/edit',
        '/app/1/weights/create',
        '/app/1/measurement-types',
        '/app/1/measurement-types/1/edit',
        '/app/1/measurement-types/create',
        '/app/1/record-categories',
        '/app/1/record-categories/1/edit',
        '/app/1/record-categories/create',
        '/app/1/record-types',
        '/app/1/record-types/1/edit',
        '/app/1/record-types/create',
        '/app/1/progression',
        '/app/1/progression/view/1',
    ];

    visit($routes)->assertNoSmoke();
});
