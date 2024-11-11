<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
		Route::get('season',[ScheduleController::class, 'getWeeklySchedule']);
		Route::get('week', [ScheduleController::class,'getGames']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
