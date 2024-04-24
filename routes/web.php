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
Route::post('/manageTAS', [DashboardController::class, 'submitForm'])->name('submitForm.tas');
Route::get('/showTAS', [DashboardController::class, 'tasShow'])->name('tas.show');

Route::get('/getChartData', [DashboardController::class, 'getChartData']);
Route::get('/{id}/profile', [DashboardController::class, 'profile'])->name('profile');
Route::get('/{id}/profile/edit', [DashboardController::class, 'edit'])->name('profile.edit');
Route::put('/{id}/profile/update', [DashboardController::class, 'update'])->name('profile.update');
Route::get('/{id}/profile/change_password', [DashboardController::class, 'change'])->name('profile.change');
Route::post('/{id}/profile/update_password', [DashboardController::class, 'updatePassword'])->name('profile.update_password');

Route::get('/manage-user', [DashboardController::class, 'management'])->name('user_management');
Route::get('/users/{id}/edit', [DashboardController::class, 'edit'])->name('users.edit');
Route::delete('/users/{user}', [DashboardController::class, 'userdestroy'])->name('users.destroy');
Route::get('/add-user', [DashboardController::class, 'add_user'])->name('add.user');
Route::post('/store-user', [DashboardController::class, 'store_user'])->name('store.user');
