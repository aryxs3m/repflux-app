<?php

namespace App\Http\Controllers\Api;

use App\Services\VersionService;

class StatusController extends ApiBaseController {
    public function index()
    {
        return $this->success([
            'name' => config('app.name'),
            'version' => VersionService::getVersion(),
        ]);
    }
}
