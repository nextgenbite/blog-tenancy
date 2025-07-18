<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenancyController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
Route::get('/artisan/{command}', function ($command) {
    Artisan::call($command);
    return Artisan::output();
});

Route::get('/', function () {
    return view('index');
});
Route::get('/tenant', [TenancyController::class, 'index'])->name('tenant.index');
Route::get('/tenant-register', [TenancyController::class, 'register']);
Route::post('/tenant-register', [TenancyController::class, 'store'])->name('tenant.register');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
