<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CompaniesApiController;
use App\Http\Controllers\API\CompanyAttestationApiController;
use App\Http\Controllers\API\MemberAcademicStatesApiController;
use App\Http\Controllers\API\MembersApiController;
use App\Http\Controllers\API\StampApiController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/companies')->namespace('Companies')->group(function () {
    Route::get('/', [CompaniesApiController::class, 'index']); // Les routes "companies.*" de l'API
    Route::get('/company/{id}', [CompaniesApiController::class, 'show']);
    Route::post('/company', [CompaniesApiController::class, 'store']);
    Route::put('/company/{id}', [CompaniesApiController::class, 'update']);
    Route::delete('/company/{id}', [CompaniesApiController::class, 'destroy']);
    Route::get('attestations', [CompanyAttestationApiController::class, 'index']);
    Route::get('attestations/{id}', [CompanyAttestationApiController::class, 'show']);
    Route::post('attestations', [CompanyAttestationApiController::class, 'store']);
    Route::put('attestations/{id}', [CompanyAttestationApiController::class, 'update']);
    Route::delete('attestations/{id}', [CompanyAttestationApiController::class, 'destroy']);
});




Route::prefix('/members')->namespace('Members')->group(function () {
    Route::get('/', [MembersApiController::class, 'index']); // Les routes "members.*" de l'API
    Route::get('member/{id}', [MembersApiController::class, 'show']);
    Route::post('member/', [MembersApiController::class, 'store']);
    Route::put('member/{id}', [MembersApiController::class, 'update']);
    Route::delete('member/{id}', [MembersApiController::class, 'destroy']);
    Route::get('academic-states', [MemberAcademicStatesApiController::class, 'index']);
    Route::get('academic-states/{id}', [MemberAcademicStatesApiController::class, 'show']);
    Route::post('academic-states', [MemberAcademicStatesApiController::class, 'store']);
    Route::put('academic-states/{id}', [MemberAcademicStatesApiController::class, 'update']);
    Route::delete('academic-states/{id}', [MemberAcademicStatesApiController::class, 'destroy']);
});

Route::get('stamps', [StampApiController::class, 'index']);
Route::get('stamps/{id}', [StampApiController::class, 'show']);
Route::post('stamps', [StampApiController::class, 'store']);
Route::put('stamps/{id}', [StampApiController::class, 'update']);
Route::delete('stamps/{id}', [StampApiController::class, 'destroy']);
