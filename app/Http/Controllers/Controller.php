<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Costruisce la risposta JSON da restituire all'interfaccia.
     *
     * @param  ....
     * @return ...
     */
    public static function makeJsonResponse($data, int $status_code = 200, ?string $message = null): JsonResponse
    {
        $success = $status_code < 400;

        return response()->json([
            'success' => $success,
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data
        ], $status_code);
    }
}
