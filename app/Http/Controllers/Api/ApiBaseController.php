<?php

namespace App\Http\Controllers\Api;

abstract class ApiBaseController {
    protected function success(array $data, int $code = 200)
    {
        return response()->json($data, $code);
    }

    protected function error(string $message, array $details = [], int $code = 500)
    {
        return response()->json(['message' => $message, 'details' => $details], $code);
    }
}
