<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
		Route::get('season',[ScheduleController::class, 'getSeason']);
		Route::get('week', [ScheduleController::class,'getGameLinks']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
