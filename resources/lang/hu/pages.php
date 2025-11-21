<?php

return [
    'measurements' => [
        'list_title' => 'Testméretek',
        'create_title' => 'Mérés hozzáadása',
        'edit_title' => 'Mérés szerkesztése',
        'bulk_create_title' => 'Tömeges mérés hozzáadás',
        'measure_now' => 'Mérés indítása',
        'add_single' => 'Egy méret rögzítése',
    ],
    'measurement_types' => [
        'list_title' => 'Testméret típusok',
        'create_title' => 'Típus hozzáadása',
        'edit_title' => 'Típus szerkesztése',
        'add_type' => 'Típus hozzáadása',
    ],
    'record_categories' => [
        'list_title' => 'Gyakorlat kategóriák',
        'create_title' => 'Kategória hozzáadása',
        'edit_title' => 'Kategória szerkesztése',
        'add_category' => 'Kategória hozzáadása',
    ],
    'record_sets' => [
        'list_title' => 'Sorozatok',
        'create_title' => 'Sorozat hozzáadása',
        'edit_title' => 'Sorozat szerkesztése',
        'view_title' => 'Sorozat megtekintése',
        'back' => 'Vissza',
        'add_set' => 'Sorozat hozzáadása',
        'clone_set' => 'Klónozás',
        'new_user' => 'Új felhasználó',
        'workout' => 'Edzés',
        'widget' => [
            'weight' => 'Súly',
            'repeats' => 'Ismétlések',
            'reps_and_weights' => 'Súlyok és ismétlések',
            'moved_weight' => [
                'title' => 'Megmozgatott súly',
                'description' => 'A sorozat során megmozgatott összes súly',
            ],
            'repetitions' => [
                'title' => 'Ismétlések',
                'description' => 'Összes ismétlés a sorozat során',
            ],
            'pr' => [
                'title' => 'PR',
                'description' => 'Valaha elért legmagasabb súly',
            ],
        ],
    ],
    'record_types' => [
        'basic_settings' => 'Alap beállítások',
        'other' => 'Egyéb',
        'list_title' => 'Gyakorlatok',
        'create_title' => 'Gyakorlat hozzáadása',
        'edit_title' => 'Gyakorlat szerkesztése',
        'add_type' => 'Gyakorlat hozzáadása',
    ],
    'weight' => [
        'list_title' => 'Testsúly napló',
        'create_title' => 'Mérés hozzáadása',
        'edit_title' => 'Mérés szerkesztése',
        'add_weight' => 'Mérés hozzáadása',
        'widgets' => [
            'weight_history' => 'Testúly történet',
            'no_weight_recorded' => 'Még nem rögzítetted a súlyodat',
            'weekly_change' => 'Heti súlyváltozás',
            'monthly_change' => 'Havi súlyváltozás',
            'days_until_target' => 'Hátralévő napok a célig',
        ],
    ],
    'progression' => [
        'list_title' => 'Előrehaladás',
        'widgets' => [
            'weight' => 'Súly',
            'weight_progression' => 'Megmozgatott súly változása (utolsó 30 sorozat)',
            'brzycki' => [
                'title' => 'Brzycki 1RM',
                'description' => 'A Brzycki képlet alapján számított max súly',
            ],
            'epley' => [
                'title' => 'Epley 1RM',
                'description' => 'Az Epley képlet alapján számított max súly',
            ],
        ],
    ],
    'workouts' => [
        'list_title' => 'Edzések',
        'edit_title' => 'Edzés szerkesztése',
        'view_title' => 'Edzés megtekintése',
        'widgets' => [
            'exercises' => 'Gyakorlatok',
            'total_reps' => 'Összes ismétlés',
            'total_weight' => 'Megmozgatott súly',
            'category' => [
                'title' => 'Gyakorlat típusok',
            ],
            'weight_progression' => [
                'title' => 'Megmozgatott súly változása hasonló edzéseknél',
                'filters' => [
                    'daily' => '30 nap',
                    'weekly' => 'Heti',
                    'halfyear' => 'Havi',
                ],
            ],
            'last_dominant_category' => 'Utolsó domináns csoport',
            'last_total_weight' => 'Utolsó edzés megmozgatott tömeg',
            'last_total_reps' => 'Utolsó edzés ismétlései',
            'heatmap_chart' => [
                'title' => 'Grind az elmúlt évben',
            ],
        ],
        'missing_records' => 'Hiányos rögzítés',
    ],
    'tenancy' => [
        'register_tenant' => 'Csapat regisztrációja',
        'edit_tenant' => 'Csapat szerkesztése',
        'default_tenant_name' => ':user csapata',
        'users' => [
            'title' => 'Felhasználók',
            'invite' => 'Meghívás',
            'kick' => 'Kirúgás',
            'has_admin' => 'Adminisztrátori jogaid vannak ezen a munkaterületen. Felhasználókat hívhatsz meg vagy rúghatsz ki.',
            'notifications' => [
                'join' => [
                    'success' => [
                        'title' => 'Sikeres csatlakozás',
                    ],
                ],
                'invitation' => [
                    'success' => [
                        'title' => 'Sikeres meghívás',
                        'body' => 'A meghívót kiküldtük e-mailben!',
                    ],
                    'fail' => [
                        'title' => 'Sikertelen meghívás',
                        'body' => 'A meghívó kiküldése meghiúsult!',
                    ],
                ],
            ],
        ],
    ],
    'calendar' => [
        'title' => 'Naptár',
        'events' => 'Események',
        'event' => [
            'weight_measurement' => 'Testsúly napló',
            'body_measurement' => 'Testméret napló',
        ],
    ],
    'dashboard' => [
        'title' => 'Áttekintés',
        'gym_greet' => 'Jó edzést!',
    ],
    'edit_profile' => [
        'system_default' => 'Rendszer alapértelmezett',
    ],
];
