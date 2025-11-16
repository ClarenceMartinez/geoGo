<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScheduleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    

    Route::resource('companies', CompanyController::class);

    // CRUD de Branches POR Empresa
    Route::resource('companies.branches', BranchController::class)->except(['show']); // opcional, no lo necesitamos
    Route::resource('companies.branches.users', EmployeeController::class)->except(['show']);
    Route::resource('companies.branches.schedules', ScheduleController::class)->except(['show']);


});


require __DIR__.'/auth.php';
