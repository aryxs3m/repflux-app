<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\CalendarService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function events(Tenant $tenant, Request $request, CalendarService $service)
    {
        if (! $tenant->users->contains(auth()->user()->id)) {
            abort(403);
        }

        $start = Carbon::parse($request->query('start'));
        $end = Carbon::parse($request->query('end'));

        return response()->json($service->getEvents($tenant, $start, $end));
    }
}
