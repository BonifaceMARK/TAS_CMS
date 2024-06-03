<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Models\TrafficViolation;
use App\Models\ApprehendingOfficer;
use App\Models\TasFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\admitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\fileviolation;
use App\Models\G5ChatMessage;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
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
})->name('landpage');

Route::get('/loginpage', [AuthController::class, 'loadlogin'])->name('login');
Route::post('/loginpost', [AuthController::class, 'login'])->name('login.submit');

Route::get('/registerpage', [AuthController::class, 'loadregister'])->name('register');
Route::post('/registerpost', [AuthController::class, 'register'])->name('register.submit');
Route::get('/logout', [AuthController::class, 'logoutx'])->name('logout');

// Middleware routes for authenticated users
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
    Route::get('/editofficer', [DashboardController::class, 'editoffi'])->name('edit.offi');
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
    Route::get('/edit/contested', [DashboardController::class, 'updateContest'])->name('update.contest.index');
    Route::get('/edit/admitted', [DashboardController::class, 'updateAdmitted'])->name('update.admit.index');
    Route::get('/officers/{departmentName}', [DashboardController::class, 'getByDepartmentName']);
    Route::put('/violations/{id}', [DashboardController::class, 'updateTas'])->name('violations.updateTas');
    Route::delete('/violations/{id}', [DashboardController::class, 'deleteTas'])->name('violations.delete');
    Route::get('/history', [DashboardController::class, 'historyIndex'])->name('history.index');
    Route::get('/AdmittedEdit', [DashboardController::class, 'editAdmit'])->name('edit.admit');
    Route::get('/print.subpoena/{id}', [DashboardController::class, 'printsub'])->name('print.sub');
    Route::post('/update-status/{id}', [DashboardController::class, 'updateStatus'])->name('update.status');
    Route::post('/finish-case/{id}', [DashboardController::class, 'finishCase'])->name('finish.case');
    Route::put('/officers/{id}', [DashboardController::class, 'updateoffi'])->name('officers.update');
    Route::put('/edit/violation/{id}', [DashboardController::class, 'updateviolation'])->name('edit.violation');
    Route::get('/edit/violation', [DashboardController::class, 'edivio'])->name('edit.vio');

    Route::get('violation/details/{id}', function ($id) {
        $violation = TrafficViolation::findOrFail($id);
        return view('ao.detailsviolation', compact('violation'));
    })->name('fetchingviolation');

    Route::get('officer/details/{id}', function ($id) {
        $officer = ApprehendingOfficer::findOrFail($id);
        return view('ao.detailsoffi', compact('officer'));
    })->name('fetchingofficer');

    Route::get('tasfile/details/{id}', [DashboardController::class, 'detailstasfile'])->name('fetchingtasfile');
    Route::get('admitted/details/{id}', [DashboardController::class, 'detailsadmitted'])->name('fetchingadmitted');
    Route::get('/fetchFinishData/{id}', [DashboardController::class, 'fetchFinishData'])->name('fetchFinishData');
    Route::post('/finishCase/{id}', [DashboardController::class, 'finishCase'])->name('finish.case');

    Route::get('/vehicle-type-data', [DashboardController::class, 'getVehicleTypeData']);
    Route::post('/tasfile/{id}/updateViolation', [DashboardController::class, 'UPDATEVIO']);
 
    Route::post('/tasfile/{id}/deleteViolation', [DashboardController::class, 'DELETEVIO']);
    Route::post('/delete-remark',  [DashboardController::class, 'deleteRemark']);
    Route::post('/tas-files/{id}/add-attachment', [DashboardController::class, 'addAttachment'])->name('add.attachment');
    Route::post('/tasfile/{id}/attach', [DashboardController::class, 'attachFiles'])->name('tasfile.attach');
        Route::get('tasfile/details/{id}',                  [DashboardController::class, 'detailstasfile'])->name('fetchingtasfile');
        Route::delete('/tasfile/{id}/remove-attachment', [DashboardController::class, 'removeAttachment'])->name('tasfile.removeAttachment');

////////////////////////////////////////////////ANALYTICS///////////////////////////////////////////////////////
route::get('/analytics/vehicle', [DashboardController::class, 'indexAnalytics'])->name('analytics.vehicle');

});

Route::get('/fetch-remarks/?id={id}', [DashboardController::class, 'fetchRemarks'])->name('fetch.remarks'); 

Route::get('/subpoena', function () { 
    $tasFile = TasFile::findOrFail(115);
    $changes = $tasFile;
    $officerName = $changes->apprehending_officer;
    $officers = ApprehendingOfficer::where('officer', $officerName)->get();

    if (!empty($changes->violation)) {
        $violations = json_decode($changes->violation);
        if ($violations !== null) {
            $relatedViolations = TrafficViolation::whereIn('code', $violations)->get();
        } else {
            $relatedViolations = [];
        }
    } else {
        $relatedViolations = [];
    }

    $holidays = [
        '01-01', // New Year's Day
        '04-09', // Araw ng Kagitingan
        '05-01', // Labor Day
        '06-12', // Independence Day
        '08-26', // National Heroes Day
        '11-30', // Bonifacio Day
        '12-25', // Christmas Day
        '02-25', // EDSA People Power Revolution Anniversary
        '08-21', // Ninoy Aquino Day
        '11-01', // All Saints' Day
        '11-02', // All Souls' Day
        '12-30', // Rizal Day
        '02-14', // Valentine's Day
        '03-08', // International Women's Day
        '10-31', // Halloween
        '04-20', // 420 (Cannabis Culture)
        '07-04', // Independence Day (United States)
        '05-14', // Additional holiday declared by the government
        '11-15', // Regional holiday
    ];

    // Get the current date
    $startDate = Carbon::now();
    $formattedDate = $startDate->format('F j, Y');

    // Calculate the new date excluding weekends and holidays
    $currentDate = clone $startDate; // Clone to avoid modifying the original start date
    $numDays = 3;

    while ($numDays > 0) {
        $currentDate->addDay();

        // Check if the current day is a weekend or a holiday
        if ($currentDate->isWeekend() || in_array($currentDate->format('m-d'), $holidays)) {
            continue; // Skip weekends and holidays
        }

        $numDays--;
    }

    $endDate = $currentDate->format('F j, Y');

    $compactData = [
        'changes' => $changes,
        'officers' => $officers,
        'relatedViolations' => $relatedViolations,
        'date' => $formattedDate,
        'hearing' => $endDate,
    ];

    // dd($compactData);

    return view('subpoena', compact('tasFile', 'compactData'));
});

// Staff routes
Route::group(['prefix' => 'user', 'middleware' => ['web', 'isUser']], function () {
    // Define user-specific routes here
});
?>
