<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ApiErrors;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    protected function prepareApiResponse($data = null, $responseCode = 200, $message = null): JsonResponse
    {
        $response['success'] = $responseCode === 200;

        if (isset($message)) {
            $response['message'] = $message;
        }

        if (isset($data)) {
            $response = array_merge($response, $data);
        }

        return response()->json($response, $responseCode);
    }

}
