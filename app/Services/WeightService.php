<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;

class WeightService {
    /**
     * Maximum allowed weight difference in kilograms/lbs to identify a user.
     */
    const MAX_DIFFERENCE = 10;

    /**
     * This function will try to get the user by it's last measured weight. It is used to store new weight measures
     * automatically even if we cannot get the user.
     *
     * @param Tenant $tenant
     * @param float $weight
     *
     * @return User|null
     */
    public function findUserByWeight(Tenant $tenant, float $weight): ?User
    {
        $userWeights = [];

        $tenant->users->each(function (User $user) use (&$userWeights) {
            $lastWeight = $user->weights()->orderBy('measured_at', 'desc')->first();
            if ($lastWeight) {
                $userWeights[$user->id] = $lastWeight->weight;
            }
        });

        foreach ($userWeights as $id => $lastWeight) {
            $userWeights[$id] = abs($lastWeight - $weight);
        }

        asort($userWeights);

        foreach ($userWeights as $id => $userWeight) {
            if ($userWeight <= self::MAX_DIFFERENCE) {
                return User::query()->find($id);
            }
        }

        return null;
    }
}
