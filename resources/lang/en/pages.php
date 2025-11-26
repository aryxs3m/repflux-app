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
        'empty_state' => 'If you want to track changes in your body measurements, add measurement types (e.g. biceps or hips). You can also request loading of starter data.',
    ],
    'record_categories' => [
        'list_title' => 'Exercise categories',
        'create_title' => 'Add category',
        'edit_title' => 'Edit category',
        'add_category' => 'Add category',
        'empty_state' => 'You can categorize individual exercises. Examples of categories include legs, shoulders, cardio, etc. You can load the default data or start recording them manually.',
    ],
    'record_sets' => [
        'list_title' => 'Sets',
        'create_title' => 'Add set',
        'edit_title' => 'Edit set',
        'view_title' => 'Show set',
        'empty_state' => 'Under sets you can record the results of each exercise.',
        'back' => 'Back',
        'add_set' => 'Add set',
        'clone_set' => 'Clone',
        'new_user' => 'New user',
        'workout' => 'Workout',
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
            'pr' => [
                'title' => 'PR',
                'description' => 'Heaviest weight ever reached',
            ],
            'time' => [
                'title' => 'Time',
                'description' => 'Measured time',
            ],
        ],
    ],
    'record_types' => [
        'basic_settings' => 'Basic settings',
        'other' => 'Other',
        'list_title' => 'Exercises',
        'create_title' => 'Add exercise',
        'edit_title' => 'Edit exercise',
        'add_type' => 'Add exercise',
        'empty_state' => 'You should add all the different exercises you perform during your workouts here. Examples include treadmill, bench press, squats, TRX exercises, etc. You can use the built-in list as a starting point or add your own.',
    ],
    'weight' => [
        'list_title' => 'Weight log',
        'create_title' => 'Add measurement',
        'edit_title' => 'Edit measurement',
        'add_weight' => 'Add measurement',
        'empty_state' => 'Here you will see changes in your weight. Add your first measurement to track your progress!',
        'widgets' => [
            'weight_history' => 'Weight history',
            'no_weight_recorded' => 'No weight recorded yet',
            'weekly_change' => 'Weekly weight change',
            'monthly_change' => 'Monthy weight change',
            'days_until_target' => 'Days until weight target',
        ],
    ],
    'progression' => [
        'list_title' => 'Progression',
        'widgets' => [
            'weight' => 'Weight',
            'weight_progression' => 'Max weight (last 30 set)',
            'brzycki' => [
                'title' => 'Brzycki 1RM',
                'description' => 'One rep max by Brzycki formula',
            ],
            'epley' => [
                'title' => 'Epley 1RM',
                'description' => 'One rep max by Epley formula',
            ],
        ],
    ],
    'workouts' => [
        'list_title' => 'Workouts',
        'edit_title' => 'Edit workout',
        'view_title' => 'Show workout',
        'empty_state' => 'Workouts are automatically created once you start adding sets.',
        'widgets' => [
            'exercises' => 'Exercises',
            'total_reps' => 'Total reps',
            'total_weight' => 'Moved weight',
            'category' => [
                'title' => 'Exercise categories',
            ],
            'weight_progression' => [
                'title' => 'Moved weight in similar workouts',
                'filters' => [
                    'daily' => '30 days',
                    'weekly' => 'Weekly',
                    'halfyear' => 'Monthly',
                ],
            ],
            'last_dominant_category' => 'Last dominant category',
            'last_total_weight' => 'Last workout total weight',
            'last_total_reps' => 'Last workout total reps',
            'heatmap_chart' => [
                'title' => 'Grind in the last year',
            ],
        ],
        'missing_records' => 'Missing records',
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
    'edit_profile' => [
        'system_default' => 'System default',
    ],
];
