<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\LoginController;

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

Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'loginForm')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
});

Route::middleware(['auth'])->controller(SubscribersController::class)->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/subscribers', 'index')->name('subscribers');
    Route::post('/subscribers/all', 'getSubscribers')->name('all-subscribers');
    Route::get('/subscribers/create', 'createForm')->name('subscriber-create-form');
    Route::post('/subscribers/store', 'store')->name('subscriber-store');
    Route::get('/subscribers/update/{id}', 'updateForm')->name('subscriber-update-form');
    Route::post('/subscribers/edit', 'edit')->name('subscriber-update');
    Route::delete('/subscribers/delete/{id}', 'delete')->name('subscriber-delete');
});
