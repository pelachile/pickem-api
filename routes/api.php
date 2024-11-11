<?php

use App\Http\Controllers\Api\v1\Auth\LoginRegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [LoginRegisterController::class, 'login']);
Route::post('/register', [LoginRegisterController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
