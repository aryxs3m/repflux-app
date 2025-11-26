<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarRequest;
use App\Models\Tenant;
use App\Services\CalendarService;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function events(Tenant $tenant, CalendarRequest $request, CalendarService $service)
    {
        if (! $tenant->users->contains(auth()->user()->id)) {
            abort(403);
        }

        $start = Carbon::parse($request->validated('start'));
        $end = Carbon::parse($request->validated('end'));

        return response()->json($service->getEvents($tenant, $start, $end));
    }
}
