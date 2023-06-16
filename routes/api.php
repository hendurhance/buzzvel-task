<?php

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\LogoutController;
use App\Http\Controllers\API\V1\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Auth Namespace
|--------------------------------------------------------------------------
|
*/

Route::prefix('auth')->as('auth.')->group(function (): void {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::post('/create', [RegisterController::class, 'create'])->name('create');
});

/*
|--------------------------------------------------------------------------
| Task Namespace
|--------------------------------------------------------------------------
|
*/

Route::prefix('task')->as('tasks.')->group(function (): void {
    // Route::get('/', 'TaskController@index')->name('index');
    // Route::post('/create', 'TaskController@create')->name('create');
    // Route::get('/{uuid}', 'TaskController@show')->name('show');
    // Route::put('/{uuid}', 'TaskController@update')->name('update');
    // Route::delete('/{uuid}', 'TaskController@delete')->name('delete');
});