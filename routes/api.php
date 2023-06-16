<?php

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\LogoutController;
use App\Http\Controllers\API\V1\Auth\RegisterController;
use App\Http\Controllers\API\V1\Task\TaskController;
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
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::post('/', [TaskController::class, 'store'])->name('store');
    Route::get('/{id}', [TaskController::class, 'show'])->name('show');
    Route::put('/{id}', [TaskController::class, 'update'])->name('update');
    Route::delete('/{id}', [TaskController::class, 'delete'])->name('delete');
});
