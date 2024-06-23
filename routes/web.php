<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/companies')->namespace('Companies')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\CompaniesController::class, 'companies']);
    Route::match(['get', 'post'], 'add-edit-company/{id?}', [App\Http\Controllers\Admin\CompaniesController::class, 'addEditCompany']);

    Route::post('/ajax-autocomplete-search-city', [App\Http\Controllers\Admin\CompaniesController::class, 'selectCitiesSearch'])->name('companies.ajax-autocomplete-search-city');
});
