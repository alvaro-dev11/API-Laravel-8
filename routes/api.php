<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Creando ruta para clients
Route::get('clients', [ClientController::class, 'index']);
Route::post('clients', [ClientController::class, 'store']);
Route::get('clients/{client}', [ClientController::class, 'show']);
Route::put('clients/{client}', [ClientController::class, 'update']);
Route::delete('clients/{client}', [ClientController::class, 'destroy']);

// Creando rutas para servicios
Route::get('services', [ServiceController::class, 'index']);
Route::post('services', [ServiceController::class, 'store']);
Route::get('services/{service}', [ServiceController::class, 'show']);
Route::put('services/{service}', [ServiceController::class, 'update']);
Route::delete('services/{service}', [ServiceController::class, 'destroy']);

// Ruta para agregar servicios a los clientes
Route::post('clients/services', [ClientController::class, 'attach']);

// Ruta para quitar servicios a los clientes
Route::post('clients/services/detach', [ClientController::class, 'detach']);

// Ruta para ver a todos los clientes que usan un servicio
Route::post('services/clients', [ServiceController::class, 'clients']);
