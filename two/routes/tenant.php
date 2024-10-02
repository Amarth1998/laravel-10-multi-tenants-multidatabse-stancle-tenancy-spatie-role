<?php
declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\App\ProfileController;


Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', function () {
        // dd(tenant()->toArray());
        // return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
        return view('app.welcome');
    });


    Route::get('/dashboard', function () {
        return view('app.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
       
       
        Route::group(['middleware' => ['role:admin']], function () { 
            Route::resource('users',UserController::class);
        });
       
       
    });
    require __DIR__.'/tenant-auth.php';
});


