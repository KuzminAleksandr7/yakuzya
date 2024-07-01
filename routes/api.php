<?php

use App\Http\Controllers\Api\DownloadController;
use App\Http\Controllers\Api\User\IndexController as UserIndexController;
use App\Http\Controllers\Api\User\StoreController as UserStoreController;
use App\Http\Controllers\Api\User\ShowController as UserShowController;
use App\Http\Controllers\Api\Position\IndexController as PositionIndexController;
use App\Http\Controllers\Api\Token\ShowController as TokenShowController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/download/cv', [DownloadController::class, 'downloadCv']);

Route::get('/users',      UserIndexController::class);
Route::post('/users',     UserStoreController::class)->middleware('guest');
Route::get('/users/{id}', UserShowController::class);

Route::get('/positions',  PositionIndexController::class);

Route::get('/token',      TokenShowController::class)->middleware('auth:sanctum');
