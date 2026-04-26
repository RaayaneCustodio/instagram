<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
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

// --- GRUPO DE USUÁRIOS ---


Route::post('/usuarios/login', [AuthController::class, 'login']);


Route::post('/usuarios', [UsuarioController::class, 'store']);


Route::middleware('auth:api')->group(function () {
    Route::post('/usuarios/logout', [AuthController::class, 'logout']);

    Route::get('/usuarios', [UsuarioController::class, 'index']);      // Listar
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show']); // Obter um
    Route::patch('/usuarios/{id}', [UsuarioController::class, 'update']); // Atualizar
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']); // Deletar
});
