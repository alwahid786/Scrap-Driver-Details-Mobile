<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\AuthController;

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

Route::get('/login_auth', [AuthController::class, 'loginAPI'])->name('loginAPI');
Route::get('/slip/detail', [AuthController::class, 'listDetail'])->name('listDetail');
Route::get('/slip/start', [AuthController::class, 'startSlip'])->name('startSlip');
Route::get('/slip/complete', [AuthController::class, 'completeSlip'])->name('completeSlip');
Route::get('/notes/change', [AuthController::class, 'saveNotes'])->name('saveNotes');
Route::get('/bin/remove', [AuthController::class, 'binRemove'])->name('binRemove');
Route::get('/bin/place', [AuthController::class, 'binPlace'])->name('binPlace');

Route::get('/', function () {
    return view('login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/listing/detail', function () {
    return view('listing-detail');
});
