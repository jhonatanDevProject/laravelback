<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrenteController;
use App\Http\Controllers\PresidenteController;

use App\Http\Controllers\VicepresidenteController;

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

Route::get('/Frenteall', [FrenteController::class, 'index']);

Route::post('/frentes', [FrenteController::class,'store']);
Route::get('/frentesMain', [FrenteController::class, 'index']);

Route::delete('/frentesDel/{id}', [FrenteController::class, 'destroy']);
Route::get('/frentes/{id}', [FrenteController::class, 'edit']);
Route::put('/frentesUpdate/{id}', [FrenteController::class, 'update']);

//preisdnetnes

//PRESIDNETE
Route::get('/presidentesMain', [PresidenteController::class, 'index']);
Route::get('/listaFrentes', [PresidenteController::class, 'create']);
Route::post('/presidentes', [PresidenteController::class, 'store']);
Route::delete('/presidentesDel/{id}', [PresidenteController::class, 'destroy']);
Route::get('/presidentes/{id}', [PresidenteController::class, 'edit']);
Route::put('/presidentesUpdate/{id}', [PresidenteController::class, 'update']);

Route::get('/vicepresidentesMain', [VicepresidenteController::class, 'index']);
//Route::get('/vicepresidentescreate', [VicepresidenteController::class, 'create']);
Route::post('/vicepresidentes', [VicepresidenteController::class, 'store']);
Route::get('/vicepresidentes/{id}', [VicepresidenteController::class, 'edit']);
Route::put('/vicepresidentesUpdate/{id}', [VicepresidenteController::class, 'update']);
Route::delete('/vicepresidentesDel/{id}', [VicepresidenteController::class, 'destroy']);




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
