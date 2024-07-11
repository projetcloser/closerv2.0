<?php

<<<<<<< HEAD
use Illuminate\Support\Facades\Route;
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CompaniesApiController;
<<<<<<< HEAD
>>>>>>> feat/map-api-automatic-addressing
=======
use App\Http\Controllers\API\MembersApiController;
>>>>>>> feat/member-crud-api-endpoint

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
<<<<<<< HEAD
>>>>>>> feat/map-api-automatic-addressing
=======


Route::get('/members', [MembersApiController::class, 'index']); // Les routes "members.*" de l'API
Route::get('/members/{id}', [MembersApiController::class, 'show']);
Route::post('/members', [MembersApiController::class, 'store']);
Route::put('/members/{id}', [MembersApiController::class, 'update']);
Route::delete('/members/{id}', [MembersApiController::class, 'destroy']);
>>>>>>> feat/member-crud-api-endpoint
