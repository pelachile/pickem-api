<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function(\Illuminate\Support\Facades\Request $request) {
    return $request;
});
