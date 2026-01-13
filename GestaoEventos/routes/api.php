<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController; // <--- Não te esqueças disto!
use App\Http\Controllers\AuthController; // <--- Não te esqueças de importar!

// Rotas Públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rotas Protegidas (Só com Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Vamos mover os eventos para aqui daqui a pouco!
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// <---------------- Alterado por gemini: As nossas rotas de Eventos
Route::apiResource('eventos', EventoController::class);

