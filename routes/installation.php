<?php

use App\Http\Controllers\InstallationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InstallationController::class,'installationFirstStep']);
Route::get('/installation_first_step', [InstallationController::class,'installationSecondStep'])->name('step1');
Route::get('/installation_second_step', [InstallationController::class,'installationThirdStep'])->name('step2');
Route::get('/installation_third_step', [InstallationController::class,'installationFourthStep'])->name('step3');
Route::get('/installation_fourth_step', [InstallationController::class,'installationFifthStep'])->name('step4');
Route::get('/installation_fifth_step', [InstallationController::class,'installationSixthStep'])->name('step5');

Route::post('/database_installation', [InstallationController::class,'database_installation'])->name('install.db');
Route::get('import_sql', [InstallationController::class,'import_sql'])->name('import_sql');
Route::post('system_settings', [InstallationController::class,'system_settings'])->name('system_settings');
Route::post('purchase_code', [InstallationController::class,'purchase_code'])->name('purchase.code');