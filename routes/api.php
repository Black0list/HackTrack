<?php

use App\Http\Controllers\HackathonController;
use App\Http\Controllers\JuryController;
use App\Http\Controllers\JuryMemberController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('jwt')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('user', [UserController::class, 'getUser']);

    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users', UserController::class);

    Route::post('/user/{user}/role/{role}', [UserController::class, 'add_role']);

    Route::get('/hackathons', [HackathonController::class, 'index']);
    Route::post('/hackathon/create', [HackathonController::class, 'store']);
    Route::put('/hackathon/{hackathon}/update', [HackathonController::class, 'update']);
    Route::delete('/hackathon/{hackathon}/delete', [HackathonController::class, 'delete']);

    Route::post('/teams/{team}/register', [TeamController::class, 'registerTeam'])->middleware(['can:isCompetitor','log']);
    Route::post('/teams/{team}/approve', [TeamController::class, 'approveTeam']);
    Route::post('/teams/{team}/reject', [TeamController::class, 'rejectTeam']);
    Route::post('/teams/{team}', [TeamController::class, 'joinTeam']);
    Route::delete('/teams/{team}', [TeamController::class, 'destroy']);
    Route::put('/teams/{team}', [TeamController::class, 'update']);
    Route::get('/teams/{team}', [TeamController::class, 'show']);
    Route::get('/teams', [TeamController::class, 'index']);

    Route::apiResource('themes', ThemeController::class);
    Route::apiResource('rules', RuleController::class);

    Route::apiResource('juries', JuryController::class)->middleware(['can:isAdmin','log']);

//    Route::apiResource('jury_members', JuryMemberController::class)->middleware(['can:isAdmin','log']);

    Route::get('/jury_members', [JuryMemberController::class, 'index']);
    Route::post('/jury_members/{jury}', [JuryMemberController::class, 'store'])->middleware(['can:isAdmin','log']);
    Route::put('/jury_members/{jury}', [JuryMemberController::class, 'update']);
    Route::get('/jury_members/{jury}', [JuryMemberController::class, 'show']);
    Route::delete('/jury_members/{jury}', [JuryMemberController::class, 'destroy']);
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::post('auth', [JuryMemberController::class, 'login']);


