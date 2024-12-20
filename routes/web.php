<?php

use App\Http\Controllers\API\AnnouncementsApiController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CashflowController;
use App\Http\Controllers\API\CitiesApiController;
use App\Http\Controllers\API\CotisationController;
use App\Http\Controllers\API\PersonalCertificateController;
use App\Http\Controllers\API\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CompaniesApiController;
use App\Http\Controllers\API\CompanyAttestationApiController;
use App\Http\Controllers\API\CountriesApiController;
use App\Http\Controllers\API\DebtsApiController;
use App\Http\Controllers\API\EventsApiController;
use App\Http\Controllers\API\FinesApiController;
use App\Http\Controllers\API\GroupsApiController;
use App\Http\Controllers\API\MemberAcademicStatesApiController;
use App\Http\Controllers\API\MembersApiController;
use App\Http\Controllers\API\StaffApiController;
use App\Http\Controllers\API\StampApiController;
use App\Http\Controllers\API\PaymentApiController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix('/companies')->namespace('Companies')->group(function () {
//     Route::get('/', [CompaniesApiController::class, 'index']); // Les routes "companies.*" de l'API
//     Route::get('/company/{id}', [CompaniesApiController::class, 'show']);
//     Route::get('attestations', [CompanyAttestationApiController::class, 'index']);
//     Route::get('attestations/{id}', [CompanyAttestationApiController::class, 'show']);
// });
