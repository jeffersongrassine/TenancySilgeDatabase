<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Front\StoreController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Subdomains Route Stores
Route::domain('{subdomain}.localhost')->group(function(){
    Route::get('/', [StoreController::class, 'index'])->name('front.store');

    Route::prefix('cart')->name('cart.')->group(function(){
        Route::get('/', [\App\Http\Controllers\Front\CartController::class, 'index'])->name('index');
        Route::get('add/{product}', [\App\Http\Controllers\Front\CartController::class, 'add'])->name('add');
        Route::get('remove/{product}', [\App\Http\Controllers\Front\CartController::class, 'remove'])->name('remove');
        Route::get('cancel', [\App\Http\Controllers\Front\CartController::class, 'cancel'])->name('cancel');
    });

    Route::name('sign.')->group(function() {
        Route::get('/sign-in', [\App\Http\Controllers\Front\AuthenticateController::class, 'index'])->name('index');
        Route::post('/sign-in', [\App\Http\Controllers\Front\AuthenticateController::class, 'signIn'])->name('in');
        Route::post('/sign-up', [\App\Http\Controllers\Front\AuthenticateController::class, 'signUp'])->name('up');
    });

    Route::get('logout', [\App\Http\Controllers\Front\AuthenticateController::class, 'logout'])->name('up');
});

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
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});

require __DIR__.'/auth.php';
