<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaticController;
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

Route::get('health', function () {
    return 'ohai';
});
Route::get('/auth/redirect', [AuthController::class, 'redirect'])->name('login');
Route::get('/auth/callback', [AuthController::class, 'callback']);

Route::get('/{path}', [StaticController::class, 'show'])
    ->where('path', '.*')
    ->middleware('auth');
