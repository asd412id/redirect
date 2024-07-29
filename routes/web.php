<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinksController;
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

Auth::routes(['register' => false, 'verify' => false]);

Route::get('xxx-register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('xxx-register', [RegisterController::class, 'register']);

Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/profile', [HomeController::class, 'profileUpdate'])->name('profile.update');

    Route::group(['middleware' => 'verified'], function () {
        Route::get('/beranda', [HomeController::class, 'index'])->name('home');

        Route::group(['prefix' => 'links'], function () {
            Route::get('/tambah', [LinksController::class, 'create'])->name('link.create');
            Route::post('/tambah', [LinksController::class, 'store'])->name('link.store');
            Route::get('/ubah/{uuid}', [LinksController::class, 'edit'])->name('link.edit');
            Route::post('/ubah/{uuid}', [LinksController::class, 'update'])->name('link.update');
            Route::get('/hapus/{uuid}', [LinksController::class, 'destroy'])->name('link.destroy');
        });
    });
});


Route::get('/', [LinksController::class, 'index'])->name('index');
Route::get('/{custom}', [LinksController::class, 'goto']);
