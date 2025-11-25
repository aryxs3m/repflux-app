<?php

namespace App\Http\Controllers\Api\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiContextRequest;
use App\Http\Requests\Api\StoreWeightRequest;
use App\Http\Resources\WeightCollection;
use App\Http\Resources\WeightResource;
use App\Models\Tenant;
use App\Models\Weight;
use App\Services\WeightService;
use Exception;
use Illuminate\Http\Request;

class WeightController extends Controller {
    public function index(ApiContextRequest $request)
    {
        \App\Services\Settings\Tenant::authenticate($request->validated('tenant_id'));

        return WeightCollection::make(
            Weight::query()
                ->where('tenant_id', $request->validated('tenant_id'))
                ->orderBy('id')
                ->latest()
                ->paginate());
    }

    /**
     * @throws Exception
     */
    public function store(StoreWeightRequest $request, WeightService $weightService)
    {
        $data = $request->validated();

        \App\Services\Settings\Tenant::authenticate($data['tenant_id']);

        $userId = $data['user_id'] ?? null;
        if ($userId === null) {
            $user = $weightService->findUserByWeight(Tenant::query()->find($data['tenant_id']), $data['weight']);

            if ($user === null) {
                throw new Exception('No user found for given weight.');
            }

            $userId = $user->id;
        }

        $weight = Weight::make([
            'user_id' => $userId,
            'measured_at' => $data['measured_at'] ?? now(),
            'weight' => $data['weight'],
        ]);

        $weight->tenant_id = $data['tenant_id'];
        $weight->save();

        return WeightResource::make($weight);
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
