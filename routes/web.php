<?php

<<<<<<< HEAD
use Illuminate\Support\Facades\Route;
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CompaniesApiController;
>>>>>>> feat/map-api-automatic-addressing

Route::get('/', function () {
    return view('welcome');
});
<<<<<<< HEAD
=======

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/companies', [CompaniesApiController::class, 'index']); // Les routes "companies.*" de l'API
Route::get('/companies/{id}', [CompaniesApiController::class, 'show']);
Route::post('/companies', [CompaniesApiController::class, 'store']);
Route::put('/companies/{id}', [CompaniesApiController::class, 'update']);
Route::delete('/companies/{id}', [CompaniesApiController::class, 'destroy']);
>>>>>>> feat/map-api-automatic-addressing
