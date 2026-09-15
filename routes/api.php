<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobMatchController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\OpportunitySkillController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSkillController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMatchController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\ProjectRequestController;
use App\Http\Controllers\ProjectSkillController;
use App\Http\Controllers\TeamMatchController;
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
Route::post(
    '/opportunities/{opportunity}/skills',
    [OpportunitySkillController::class, 'addSkill']
)->middleware('auth:sanctum');
Route::get(
    '/opportunities/{opportunity}',
    [OpportunityController::class, 'getById']
);
Route::get(
    '/profiles/{profile}/job-matches',
    [JobMatchController::class, 'getByProfile']
)->middleware('auth:sanctum');
Route::post('/projects', [ProjectController::class, 'create'])
    ->middleware('auth:sanctum');

Route::get('/projects', [ProjectController::class, 'getAll']);

Route::get('/projects/{project}', [ProjectController::class, 'getById']);

Route::post(
    '/projects/{project}/skills',
    [ProjectSkillController::class, 'addSkill']
)->middleware('auth:sanctum');

Route::post(
    '/profiles/{profile}/projects/{project}/match',
    [ProjectMatchController::class, 'match']
)->middleware('auth:sanctum');

Route::get(
    '/profiles/{profile}/project-matches',
    [ProjectMatchController::class, 'getByProfile']
)->middleware('auth:sanctum');

Route::post('/projects/{project}/members', [ProjectMemberController::class, 'addMember'])
    ->middleware('auth:sanctum');

Route::post('/projects/{project}/join', [ProjectRequestController::class, 'joinProject'])
    ->middleware('auth:sanctum');

Route::get('/projects/{project}/requests', [ProjectRequestController::class, 'getRequests'])
    ->middleware('auth:sanctum');

Route::post('/project-requests/{projectRequest}/accept', [ProjectRequestController::class, 'acceptRequest'])
    ->middleware('auth:sanctum');

Route::post('/project-requests/{projectRequest}/reject', [ProjectRequestController::class, 'rejectRequest'])
    ->middleware('auth:sanctum');

Route::get('/projects/{project}/team-matches', [TeamMatchController::class, 'match'])
    ->middleware('auth:sanctum');

Route::get('/projects/{project}/members', [ProjectMemberController::class, 'getMembers'])
    ->middleware('auth:sanctum');

Route::delete('/project-members/{member}', [ProjectMemberController::class, 'removeMember'])
    ->middleware('auth:sanctum');
