<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\IndexRequest;
use App\Http\Resources\Api\User\IndexResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class IndexController extends ApiController
{
    public function __invoke(IndexRequest $request): JsonResponse
    {
        $request->validated();

        $perPage = $request->count ?? config('pagination.per_page');
        $users = User::paginate($perPage)->appends(['count' => $perPage]);

        return count($users) ? $this->prepareApiResponse(IndexResource::make($users)->resolve())
            : $this->prepareApiResponse(null, 422, 'Users not found');
    }
}
