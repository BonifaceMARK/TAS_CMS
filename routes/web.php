<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
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
// Route::middleware(['auth', 'session.expiry'])->group(function () {
//     // Your routes requiring authentication and session expiry check
// });
Route::get('/', function () {
    return view('welcome');
});

Route::get('/loginpage', [AuthController::class, 'loadlogin'])->name('login');
Route::post('/loginpost', [AuthController::class, 'login'])->name('login.submit');

Route::get('/registerpage', [AuthController::class, 'loadregister'])->name('register');
Route::post('/registerpost', [AuthController::class, 'register'])->name('register.submit');
Route::get('/logout', [AuthController::class, 'logoutx'])->name('logout');

// start middleware
Route::middleware(['auth'])->group(function () {
    
        Route::get('/dashboard', [DashboardController::class, 'indexa'])->name('dashboard');
        Route::get('/analytics', [DashboardController::class, 'analyticsDash'])->name('analytics.index');
        Route::get('/tables', [DashboardController::class, 'tables'])->name('tables');
        Route::get('/manageTAS', [DashboardController::class, 'tasManage'])->name('tas.manage');
        Route::get('/viewTAS', [DashboardController::class, 'tasView'])->name('tas.view');
        Route::get('/archives', [DashboardController::class, 'caseIndex'])->name('case.view');

        Route::post('/manageTAS', [DashboardController::class, 'submitForm'])->name('submitForm.tas');
       
        Route::get('/admitTAS', [DashboardController::class, 'admitview'])->name('admitted.view');
        Route::get('/admit.manageform', [DashboardController::class, 'admitmanage'])->name('admitted.manage');
        Route::post('/admit.manageform', [DashboardController::class, 'admittedsubmit'])->name('admittedsubmit.tas');

        Route::get('/apprehending.officer', [DashboardController::class, 'officergg'])->name('see.offi');
        Route::post('/store.officer', [DashboardController::class, 'save_offi'])->name('save.offi');
        Route::get('/violation', [DashboardController::class, 'violationadd'])->name('see.vio');
        Route::post('/save.violation', [DashboardController::class, 'addvio'])->name('add.violation');
        Route::post('/admit-remarks', [DashboardController::class, 'admitremark'])->name('admitremark');
        Route::post('/save-remarks', [DashboardController::class, 'saveRemarks'])->name('save.remarks');
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

        Route::get('/chat', [DashboardController::class, 'chatIndex'])->name('chat.index');
        Route::post('/storeChat', [DashboardController::class, 'storeMessage'])->name('chat.store');

        Route::put('/admitted-cases/{id}', [DashboardController::class, 'updateAdmittedCase'])->name('admitted-cases.update');
    
        Route::get('/officers/{departmentName}', [DashboardController::class, 'getByDepartmentName']);
        

        Route::put('/violations/{id}', [DashboardController::class, 'updateTas'])->name('violations.updateTas');
        Route::delete('/violations/{id}', [DashboardController::class, 'deleteTas'])->name('violations.delete');



            
        Route::get('/print.subpoena/{id}', [DashboardController::class, 'printsub'])->name('print.sub');
});

Route::get('/subpoena', function () {
    return view('sub.print');
});
// create for staff
// Route::middleware(['auth'])->group(function () {
//     Route::prefix('employee')->group(function () {
//         Route::get('/dashboard', [DashboardController::class, 'indexa'])->name('dashboard');
//         Route::get('/viewTAS', [DashboardController::class, 'tasView'])->name('tas.view');
//         Route::post('/save-remarks', [DashboardController::class, 'saveRemarks'])->name('save.remarks');
//         Route::get('/admitTAS', [DashboardController::class, 'admitview'])->name('admitted.view');

//         Route::get('/getChartData', [DashboardController::class, 'getChartData']);
//         Route::get('/{id}/profile', [DashboardController::class, 'profile'])->name('profile');
//         Route::get('/{id}/profile/edit', [DashboardController::class, 'edit'])->name('profile.edit');
//         Route::put('/{id}/profile/update', [DashboardController::class, 'update'])->name('profile.update');
//         Route::get('/{id}/profile/change_password', [DashboardController::class, 'change'])->name('profile.change');
//         Route::post('/{id}/profile/update_password', [DashboardController::class, 'updatePassword'])->name('profile.update_password');
//     });
// });
Route::group(['prefix' => 'user','middleware'=>['web','isUser']],function(){




});