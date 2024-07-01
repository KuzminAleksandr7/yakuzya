<?php

namespace App\Http\Controllers\Api\Token;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;

class ShowController extends ApiController
{
    use HasApiTokens;

    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        $token = $user->tokens()->latest()->first();

        if (!$token) {
            $user->createToken('token');
        }

        return $this->prepareApiResponse(['token' => $user->tokens()->latest()->first()->token]);
    }
}
