<?php

namespace App\Http\Controllers\Api\Position;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\Position\IndexResource;
use App\Models\Position;
use Illuminate\Http\JsonResponse;

class IndexController extends ApiController
{
    public function __invoke(): JsonResponse
    {
        $positions = Position::all();

        return count($positions) ? $this->prepareApiResponse(IndexResource::make($positions)->resolve())
            : $this->prepareApiResponse(null, 422, 'Positions not found');
    }
}
