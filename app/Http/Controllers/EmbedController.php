<?php

namespace App\Http\Controllers;

use App\Models\User;

class EmbedController extends Controller {
    public function debug(string $hash)
    {
        return view('widget.debug', [
            'url' => route('embed.widget', ['hash' => $hash]),
        ]);
    }

    public function widget(string $hash)
    {
        return view('widget.widget', [
            'hash' => $hash,
            'data' => [
                'last_workout' => '5 days ago',
                'last_prs' => [
                    [
                        'exercise' => 'Leg press',
                        'weight' => 133,
                        'unit' => 'kg',
                    ],
                    [
                        'exercise' => 'Squat',
                        'weight' => 70,
                        'unit' => 'kg',
                    ],
                    [
                        'exercise' => 'Bench press',
                        'weight' => 50,
                        'unit' => 'kg',
                    ],
                ],
            ]
        ]);
    }

    public function data(User $user)
    {
        return response()->json([
            'last_workout' => '5 days ago',
            'last_prs' => [
                [
                    'exercise' => 'Leg press',
                    'weight' => 133,
                    'unit' => 'kg',
                ],
                [
                    'exercise' => 'Squat',
                    'weight' => 70,
                    'unit' => 'kg',
                ],
                [
                    'exercise' => 'Bench press',
                    'weight' => 50,
                    'unit' => 'kg',
                ],
            ],
        ]);
    }
}
