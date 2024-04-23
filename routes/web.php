<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/loginpage', [AuthController::class, 'loadlogin'])->name('login');
Route::post('/loginpost', [AuthController::class, 'login'])->name('login.submit');

Route::get('/registerpage', [AuthController::class, 'loadregister'])->name('register');
Route::post('/registerpost', [AuthController::class, 'register'])->name('register.submit');
Route::get('/logout', [AuthController::class, 'logoutx'])->name('logout');


Route::get('/dashboard', [DashboardController::class, 'indexa'])->name('dashboard');
Route::get('/tables', [DashboardController::class, 'tables'])->name('tables');

Route::get('/manageTAS', [DashboardController::class, 'tasManage'])->name('tas.manage');
Route::get('/viewTAS', [DashboardController::class, 'tasView'])->name('tas.view');

Route::post('/save-remarks', [DashboardController::class, 'saveRemarks'])->name('save.remarks');