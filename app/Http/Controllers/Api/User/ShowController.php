<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\ShowRequest;
use App\Http\Resources\Api\User\ShowResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ShowController extends ApiController
{
    public function __invoke(ShowRequest $request, $id): JsonResponse
    {
        $request->validated('userId', $id);

        $user = User::find($id);

        return $user ? $this->prepareApiResponse(ShowResource::make($user)->resolve())
            : $this->prepareApiResponse(null, 404, 'User not found');
    }
}
