<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\ProfileController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {

        // dd(User::get()->toArray());
        $posts = Post::get();
        return view('tenant.index',compact('posts') );
    });


    Route::middleware('auth.tenant')->group(function () {
        Route::get('/dashboard', function () {
            return view('tenant.dashboard');
        })->name('tenant.dashboard');


        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/tenant_auth.php';
});
