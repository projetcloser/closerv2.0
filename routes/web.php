<?php

use App\Http\Controllers\API\CashflowController;
use App\Http\Controllers\API\CotisationController;
use App\Http\Controllers\API\PersonalCertificateController;
use App\Http\Controllers\API\PersonnelController;
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

// Stamps
Route::get('stamps', [StampApiController::class, 'index']);
Route::get('stamps/{id}', [StampApiController::class, 'show']);
Route::post('stamps', [StampApiController::class, 'store']);
Route::put('stamps/{id}', [StampApiController::class, 'update']);
Route::delete('stamps/{id}', [StampApiController::class, 'destroy']);

// Personnel
Route::prefix('personnels')->group(function () {
    // Récupérer tous les personnels
    Route::get('/', [PersonnelController::class, 'index']);

    // Récupérer un personnel spécifique
    Route::get('personnel/{id}', [PersonnelController::class, 'show']);

    // Créer un nouveau personnel
    Route::post('personnel/', [PersonnelController::class, 'store']);

    // Mettre à jour un personnel spécifique
    Route::put('personnel/{id}', [PersonnelController::class, 'update']);

    // Supprimer un personnel spécifique
    Route::delete('personnel/{id}', [PersonnelController::class, 'destroy']);
});


//Caisse


Route::prefix('cashflows')->group(function () {
    // Récupérer tous les cashflows différents de 1 (open_close)
    Route::get('/', [CashflowController::class, 'index']);

    // Récupérer un cashflow spécifique
    Route::get('/{id}', [CashflowController::class, 'show']);

    // Créer un nouveau cashflow
    Route::post('/', [CashflowController::class, 'store']);

    // Mettre à jour un cashflow spécifique
    Route::put('/{id}', [CashflowController::class, 'update']);

    // "Supprimer" un cashflow spécifique (mettre open_close à 1)
    Route::delete('/{id}', [CashflowController::class, 'destroy']);
});


// Cotisaiton
Route::prefix('cotisations')->group(function () {
    // Récupérer toutes les cotisations différentes de 1 (open_close)
    Route::get('/', [CotisationController::class, 'index']);

    // Récupérer une cotisation spécifique
    Route::get('/{id}', [CotisationController::class, 'show']);

    // Créer une nouvelle cotisation
    Route::post('/', [CotisationController::class, 'store']);

    // Mettre à jour une cotisation spécifique
    Route::put('/{id}', [CotisationController::class, 'update']);

    // "Supprimer" une cotisation spécifique (mettre open_close à 1)
    Route::delete('/{id}', [CotisationController::class, 'destroy']);
});

// Attestion personnel

// Routes pour l'entité PersonalCertificate

// Cotisaiton
Route::prefix('personal-certificates')->group(function () {
    // Récupérer toutes les cotisations différentes de 1 (open_close)
    Route::get('/', [PersonalCertificateController::class, 'index']);

    // Récupérer une cotisation spécifique
    Route::get('/{id}', [PersonalCertificateController::class, 'show']);

    // Créer une nouvelle cotisation
    Route::post('/', [PersonalCertificateController::class, 'store']);

    // Mettre à jour une cotisation spécifique
    Route::put('/{id}', [PersonalCertificateController::class, 'update']);

    // "Supprimer" une cotisation spécifique (mettre open_close à 1)
    Route::delete('/{id}', [PersonalCertificateController::class, 'destroy']);
});
