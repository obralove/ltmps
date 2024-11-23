<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivestockController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\VaccinationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\LivestockController::class, 'index'])->name('index');


Route::get('/livestocks', [App\Http\Controllers\LivestockController::class, 'index'])
    ->name('livestocks')
    ->middleware('auth');

    


Route::get('/livestocks/{id}/edit', [App\Http\Controllers\LivestockController::class, 'edit'])->name('livestocks.edit');
Route::put('/livestocks/{id}', [App\Http\Controllers\LivestockController::class, 'update'])->name('livestocks.update');


Route::delete('/livestocks/{id}', [App\Http\Controllers\LivestockController::class, 'destroy'])->name('livestocks.destroy');


Route::get('/livestock/{id}/generate-qr-code', [QrCodeController::class, 'generate'])->name('livestock.generateQrCode');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');


Route::post('/login', [AuthController::class, 'login']);


Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');


Route::post('/register', [AuthController::class, 'register']);


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.forgot.view');
Route::post('/forgot-password', [AuthController::class, 'sendEmailPassword'])->middleware('guest')->name('password.forgot');

Route::get('/livestock/{id}', [MedicalRecordController::class, 'index'])->name('livestocks');
Route::get('/livestock/{id}', [VaccinationController::class, 'index'])->name('livestock');




Route::get('/livestock/{id}', [MedicalRecordController::class, 'show'])->name('livestocks.show');

Route::get('/livestocks/showdeleted', [LivestockController::class, 'showdeleted'])->name('livestocks.showdeleted');

Route::get('/livestocks/create', [App\Http\Controllers\LivestockController::class, 'create'])->name('livestock.create');
Route::post('/livestocks/store', [App\Http\Controllers\LivestockController::class, 'store'])->name('livestock.store');

Route::get('/medical/create/{livestockId}', [App\Http\Controllers\MedicalRecordController::class, 'create'])->name('medical.create');
Route::post('/medical/store', [App\Http\Controllers\MedicalRecordController::class, 'store'])->name('medical.store');

Route::get('/vaccination/create/{livestockId}', [App\Http\Controllers\VaccinationController::class, 'create'])->name('vaccination.create');
Route::post('/vaccination/store', [App\Http\Controllers\VaccinationController::class, 'store'])->name('vaccination.store');

Route::get('/livestocks/{livestock}', [LivestockController::class, 'show'])->name('livestocks.show');




Route::get('/medicals/{id}/edit', [App\Http\Controllers\MedicalRecordController::class, 'edit'])->name('medicals.edit');
Route::put('/medicals/{id}', [App\Http\Controllers\MedicalRecordController::class, 'update'])->name('medicals.update');
Route::delete('/medicals/{id}', [App\Http\Controllers\MedicalRecordController::class, 'destroy'])->name('medicals.destroy');


Route::get('/vaccinations/{id}/edit', [VaccinationController::class, 'edit'])->name('vaccinations.edit');
Route::put('/vaccinations/{id}/update', [VaccinationController::class, 'update'])->name('vaccinations.update');
Route::delete('/vaccinations.delete/{id}', [VaccinationController::class, 'destroy'])->name('vaccinations.destroy');


Route::resource('medicals', MedicalRecordController::class);
Route::resource('livestocks', LivestockController::class);
