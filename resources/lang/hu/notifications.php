<?php

return [
    'greeting' => 'Hali!',

    'invite' => [
        'subject' => '💪 Repflux meghívás',
        'body' => 'Meghívtak a(z) ":tenant" Repflux csapatba.',
        'accept_invite' => 'Csatlakozás',
    ],

    'outdated-body-measurements' => [
        'subject' => '💪 Repflux méréseid elavultak',
        'body' => 'Utoljára :ago töltöttél fel mérési adatokat. Frissítsd a méreteid, hogy követhesd a progressziód!',
        'measure_now' => 'Mérés',
    ],

    'outdated-weight-measurements' => [
        'subject' => '💪 Repflux méréseid elavultak',
        'body' => 'Utoljára :ago frissítetted a testsúlyod. Mérd meg magad, hogy követhesd a progressziód!',
        'measure_now' => 'Mérés',
    ],

    'workout' => [
        'sync_failed' => 'Sikertelen szinkronizáció',
        'multiple_workout_exception' => 'Erre a napra több edzés van rögzítve, nem tudtam automatikusan csatolni a sorozatot.',
        'workout_not_found_exception' => 'Erre a napra nincs edzés rögzítve, nem tudtam automatikusan csatolni a sorozatot.',
    ],
];
