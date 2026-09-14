<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobMatchController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSkillController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post(
    '/profiles/{profile}/opportunities/{opportunity}/match',
    [JobMatchController::class, 'match']
)->middleware('auth:sanctum');

Route::post('/profile', [ProfileController::class, 'createOrUpdate'])
    ->middleware('auth:sanctum');
Route::post(
    '/profiles/{profile}/skills',
    [ProfileSkillController::class, 'addSkill']
)->middleware('auth:sanctum');
Route::get('/profile', [ProfileController::class, 'getMyProfile'])
    ->middleware('auth:sanctum');

Route::post('/opportunities', [OpportunityController::class, 'create'])
    ->middleware('auth:sanctum');

Route::get('/opportunities', [OpportunityController::class, 'getAll']);
