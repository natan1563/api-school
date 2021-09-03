<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ControllerUser;
use App\Http\Controllers\EscolasController;
use App\Http\Controllers\EstudantesController;
use App\Http\Controllers\TurmasController;
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

Route::post('login',    [AuthController::class, 'login']);
Route::post('register', [ControllerUser::class, 'store']);

Route::group(['middleware' => ['apiJwt']], function() {
    Route::prefix('escolas')->group(function () {
        Route::get('',               [EscolasController::class, 'index']);
        Route::post('insert',        [EscolasController::class, 'store']);
        Route::put('update/{id}',    [EscolasController::class, 'update']);
        Route::delete('delete/{id}', [EscolasController::class, 'destroy']);
    });

    Route::prefix('turmas')->group(function () {
        Route::get('',               [TurmasController::class, 'index']);
        Route::post('insert',        [TurmasController::class, 'store']);
        Route::put('update/{id}',    [TurmasController::class, 'update']);
        Route::delete('delete/{id}', [TurmasController::class, 'destroy']);
    });

    Route::prefix('estudantes')->group(function () {
        Route::get('',               [EstudantesController::class, 'index']);
        Route::post('insert',        [EstudantesController::class, 'store']);
        Route::put('update/{id}',    [EstudantesController::class, 'update']);
        Route::delete('delete/{id}', [EstudantesController::class, 'destroy']);
    });
});

