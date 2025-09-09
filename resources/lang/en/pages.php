<?php

return [
    'measurements' => [
        'list_title' => 'Measurements',
        'create_title' => 'Add measurement',
        'edit_title' => 'Edit measurement',
        'bulk_create_title' => 'Bulk add',
        'measure_now' => 'Measure now',
        'add_single' => 'Add single measurement',
    ],
    'measurement_types' => [
        'list_title' => 'Measurement types',
        'create_title' => 'Add new type',
        'edit_title' => 'Edit type',
        'add_type' => 'Add type',
    ],
    'record_categories' => [
        'list_title' => 'Exercise categories',
        'create_title' => 'Add category',
        'edit_title' => 'Edit category',
        'add_category' => 'Add category',
    ],
    'record_sets' => [
        'list_title' => 'Sets',
        'create_title' => 'Add set',
        'edit_title' => 'Edit set',
        'view_title' => 'Show set',
        'add_set' => 'Add set',
        'widget' => [
            'weight' => 'Weight',
            'repeats' => 'Reps',
            'reps_and_weights' => 'Reps and weights',
            'moved_weight' => [
                'title' => 'Moved weight',
                'description' => 'Total moved weight in this set',
            ],
            'repetitions' => [
                'title' => 'Repetitions',
                'description' => 'Total repetitions in this set',
            ],
        ],
    ],
    'record_types' => [
        'list_title' => 'Exercises',
        'create_title' => 'Add exercise',
        'edit_title' => 'Edit exercise',
        'add_type' => 'Add exercise',
    ],
    'weight' => [
        'list_title' => 'Weight log',
        'create_title' => 'Add measurement',
        'edit_title' => 'Edit measurement',
        'add_weight' => 'Add measurement',
        'widgets' => [
            'weight_history' => 'Weight history',
            'no_weight_recorded' => 'No weight recorded yet',
        ],
    ],
    'progression' => [
        'list_title' => 'Progression',
        'widgets' => [
            'weight' => 'Weight',
            'weight_progression' => 'Max weight (last 30 set)',
        ],
    ],
    'tenancy' => [
        'register_tenant' => 'Register tenant',
        'edit_tenant' => 'Edit tenant',
        'default_tenant_name' => ':user tenant',
        'users' => [
            'title' => 'Users',
            'invite' => 'Invite',
            'kick' => 'Kick',
            'has_admin' => 'You have administrator rights in this tenant. You can invite or kick users.',
            'notifications' => [
                'join' => [
                    'success' => [
                        'title' => 'Successful join',
                    ],
                ],
                'invitation' => [
                    'success' => [
                        'title' => 'Invitation sent',
                        'body' => 'An email sent to your friend.',
                    ],
                    'fail' => [
                        'title' => 'Failed to invite',
                        'body' => 'Failed to send invitation.',
                    ],
                ],
            ],
        ],
    ],
    'calendar' => [
        'title' => 'Calendar',
        'events' => 'Events',
        'event' => [
            'weight_measurement' => 'Weight Measurement',
            'body_measurement' => 'Body Measurement',
        ],
    ],
    'dashboard' => [
        'title' => 'Overview',
        'gym_greet' => 'Have a good workout!',
    ],
];
