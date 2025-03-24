<?php

use App\Http\Controllers\HackathonController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

    Route::get('role', [RoleController::class, 'add_role']);






    Route::post('/hackathon/create', [HackathonController::class, 'store']);
    Route::put('/hackathon/{hackathon}/update', [HackathonController::class, 'update']);
    Route::delete('/hackathon/{hackathon}/delete', [HackathonController::class, 'delete']);


    Route::post('/hackathons/{hackathon}/register', [TeamController::class, 'registerTeam']);
    Route::post('/teams/{team}/approve', [TeamController::class, 'approveTeam']);
    Route::post('/teams/{team}/reject', [TeamController::class, 'rejectTeam']);
});











Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


