<?php

use Illuminate\Http\Request;
use App\Http\Controllers\WeatherController;
use App\Http\Middleware\CheckXToken;
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
Route::middleware([CheckXToken::class])->group(function () {
    Route::get('/weather', [WeatherController::class, 'getWeather']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
