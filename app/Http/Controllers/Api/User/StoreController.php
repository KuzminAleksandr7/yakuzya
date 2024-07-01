<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class StoreController extends ApiController
{
    public function __construct(protected ImageService $imageService) {}

    public function __invoke(StoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $this->imageService->optimizeImage($request->file('photo'));
        }

        event(new Registered($user = User::create($validated)));

        Auth::guard()->login($user);

        return $this->prepareApiResponse(['user_id' => $user->id], 200, 'New user successfully registered');
    }

}
