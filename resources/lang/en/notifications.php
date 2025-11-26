<?php

return [
    'greeting' => 'Hi!',

    'success' => 'Success',
    'starter_data_loaded' => 'Default data loaded!',

    'invite' => [
        'subject' => '💪 Repflux invitation',
        'body' => 'You have been invited to ":tenant" in Repflux.',
        'accept_invite' => 'Accept Invite',
    ],

    'outdated-body-measurements' => [
        'subject' => '💪 Repflux measurements outdated',
        'body' => 'Your last measurement was :ago. Measure yourself to keep track of your progress!',
        'measure_now' => 'Measure Now',
    ],

    'outdated-weight-measurements' => [
        'subject' => '💪 Repflux measurements outdated',
        'body' => 'Your last weight measurement was :ago. Measure yourself to keep track of your progress!',
        'measure_now' => 'Measure Now',
    ],

    'workout' => [
        'sync_failed' => 'Failed sync',
        'multiple_workout_exception' => 'There are multiple workouts for that day. I could not attach this set.',
        'workout_not_found_exception' => 'There are no workout created for that day. I could not attach this set.',
        'missing_records' => [
            'subject' => '🤯 Missing record in yesterday\'s workout',
            'body' => 'Yesterday\'s workout is missing some records for you or your partner (count: :count). Please make sure to record them!',
            'body_details' => 'Exercises: :list',
            'button' => 'Open workout',
        ],
    ],
];
