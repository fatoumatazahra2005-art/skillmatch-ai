<?php

use App\Http\Controllers\JobMatchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post(
    '/profiles/{profile}/opportunities/{opportunity}/match',
    [JobMatchController::class, 'match']
)->middleware('auth:sanctum');
