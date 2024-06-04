<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\TasFile;
use App\Models\admitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ApprehendingOfficer;
use App\Models\TrafficViolation;
use App\Models\fileviolation;
use App\Models\G5ChatMessage;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DateTime;


class DashboardController extends Controller
{
    public function indexa(){
            $revenueThisMonth = TasFile::whereMonth('date_received', date('m'))->count();

            $previousMonthRevenue = TasFile::whereMonth('date_received', Carbon::now()->subMonth())->count();

            // // Calculate the percentage change
            // $percentageChange = $previousMonthRevenue > 0 ? (($revenueThisMonth - $previousMonthRevenue) / $previousMonthRevenue) * 100 : 0;

            // $percentageChange = $previousYearCustomers > 0 ? (($customersThisYear - $previousYearCustomers) / $previousYearCustomers) * 100 : 0;
            $recentActivity = TasFile::whereDate('created_at', today())->latest()->take(5)->get();
            $customersThisYear = TasFile::whereYear('date_received', now())->count();
            $recentSalesToday = TasFile::whereDate('created_at', today())->latest()->take(5)->get();
            $averageSalesLastWeek = TasFile::whereBetween('created_at', [Carbon::now()->subDays(7)->startOfDay(), Carbon::now()->subDays(1)->endOfDay()])->count() / 7;
            $admittedData = Admitted::all();
            $tasFileData = TasFile::all();
            $chartData = $admittedData->map(function ($item) {
            $violationCount = 0;
            if ($item->violation) {
                $violations = json_decode($item->violation);
                $violationCount = is_array($violations) ? count($violations) : 0;
            }
            return [
                'name' => $item->name,
                'violation_count' => $violationCount,
                'transaction_date' => $item->transaction_date,
            ];
        });
        $departmentsData = ApprehendingOfficer::all();
        $unreadMessageCount = G5ChatMessage::where('is_read', false)->count();
        $messages = G5ChatMessage::latest()->with('user')->limit(10)->get();
        $user = Auth::user();
        $name = $user->name;
        $department = $user->department;
        $allMonths = collect(range(1, 12))->map(function ($month) {
            return ['month' => $month, 'record_count' => 0];
        });
        $countByMonth = TasFile::select(
                DB::raw('MONTH(date_received) as month'),
                DB::raw('COUNT(*) as record_count')
            )
            ->groupBy(DB::raw('MONTH(date_received)'))
            ->get()
            ->keyBy('month');

        $countByMonth = $allMonths->map(function ($month) use ($countByMonth) {
            return $countByMonth->has($month['month']) ? $countByMonth[$month['month']] : $month;
        });

        $countByMonth = $countByMonth->sortBy('month')->values();
        $yearlyData = TasFile::select(
        DB::raw('IFNULL(YEAR(date_received), "Unknown") as year'),
        DB::raw('COUNT(*) as record_count')
        )
        ->groupBy(DB::raw('IFNULL(YEAR(date_received), "Unknown")'))
        ->get()
        ->keyBy('year');
        // Get today's date
        $today = Carbon::now()->format('Y-m-d');

        // Fetch the data created on today's date
        $salesToday = TasFile::whereDate('created_at', $today)->get();
        $officers = TasFile::leftJoin('apprehending_officers', 'tas_files.apprehending_officer', '=', 'apprehending_officers.officer')
        ->select('tas_files.apprehending_officer', 'apprehending_officers.department')
        ->selectRaw('COUNT(tas_files.apprehending_officer) as total_cases')
        ->selectRaw('GROUP_CONCAT(tas_files.case_no) as case_numbers')
        ->groupBy('tas_files.apprehending_officer', 'apprehending_officers.department')
        ->orderByDesc('total_cases')
        ->get();


        return view('index', compact('officers','yearlyData','countByMonth','unreadMessageCount','messages', 'name', 'department','departmentsData','tasFileData','admittedData','chartData','recentActivity', 'recentSalesToday', 'salesToday', 'revenueThisMonth', 'customersThisYear', 'averageSalesLastWeek'));
       // return view('index', compact('recentActivity', 'recentSalesToday', 'salesToday', 'revenueThisMonth', 'customersThisYear', 'averageSalesLastWeek','previousYearCustomers', 'previousMonthRevenue', 'percentageChange'));
    }
    public function editViolation(Request $request, $id){
        $violation = Violation::find($id);


        if (!$violation) {
            return redirect()->back()->with('error', 'Violation not found.');
        }
        $validatedData = $request->validate([
        ]);
        $violation->update($validatedData);
        return redirect()->back()->with('success', 'Violation updated successfully.');
    }
    public function chatIndex(){
        $messages = G5ChatMessage::latest()->with('user')->limit(10)->get();
        $user = Auth::user();
        $name = $user->name;
        $department = $user->department;
        $unreadMessageCount = G5ChatMessage::where('is_read', false)->count();
        return view('chat',compact('unreadMessageCount','messages', 'name', 'department'));
    }
    public function storeMessage(Request $request){
        $request->validate([
            'message' => 'required|string',
        ]);
        $message = new G5ChatMessage();
        $message->message = $request->input('message');
        $message->user_id = Auth::id();
        $message->save();
        return redirect()->back()->with('success', 'Message sent successfully.');
    }
    public function getByDepartmentName($departmentName){
        $officers = ApprehendingOfficer::where('department', $departmentName)->get();
        return response()->json($officers);
    }
    public function tables(){
        return view('layout');
    }
    public function tasManage(){
        $officers = ApprehendingOfficer::select('officer', 'department')->get();
        // dd($recentViolationsToday[1]);
        $violations = TrafficViolation::orderBy('code', 'asc')->get();
        return view('tas.manage',compact('officers','violations'));
    }
    public function updateAdmittedCase(Request $request, $id){
        // Validate the request
        $validatedData = $request->validate([
            'editTop' => 'required|string',
            'editName' => 'required|string',
            'editViolation' => 'required|string',
            'editTransactionNo' => 'required|string',
            'editTransactionDate' => 'required|date',
            'editPlateNo' => 'required|string',
            'editContactNo' => 'required|string',
            'editRemarks' => 'nullable|string',
        ]);

        // Find the admitted case by id
        $admittedCase = AdmittedCase::findOrFail($id);

        // Update attributes
        $admittedCase->update([
            'top' => $request->input('editTop'),
            'name' => $request->input('editName'),
            'violation' => $request->input('editViolation'),
            'transaction_no' => $request->input('editTransactionNo'),
            'transaction_date' => $request->input('editTransactionDate'),
            'plate_no' => $request->input('editPlateNo'),
            'contact_no' => $request->input('editContactNo'),
            'remarks' => $request->input('editRemarks'),
            // Add other attributes if needed
        ]);

        // Redirect back or to a success page
        return redirect()->back()->with('success', 'Admitted case updated successfully');
    }
    public function caseIndex(){
        return view('case_archives');
    }
    public function tasView(){
        $pageSize = 15; // Define the default page size
        $tasFiles = TasFile::all()->sortByDesc('case_no');
        $officers = collect();
        
        foreach ($tasFiles as $tasFile) {
            $officerName = $tasFile->apprehending_officer;
            $officersForFile = ApprehendingOfficer::where('officer', $officerName)->get();
            $officers = $officers->merge($officersForFile);
            $tasFile->relatedofficer = $officersForFile;
            
            if (is_string($tasFile->remarks)) {
                $remarks = json_decode($tasFile->remarks, true);
                if ($remarks === null) {
                    $remarks = [];
                }
            } else if (is_array($tasFile->remarks)) {
                $remarks = $tasFile->remarks;
            } else {
                $remarks = [];
            }
            $tasFile->remarks = $remarks;

            $violations = json_decode($tasFile->violation);
            if ($violations) {
                if (is_array($violations)) {
                    $relatedViolations = TrafficViolation::whereIn('code', $violations)->get();
                } else {
                    $relatedViolations = TrafficViolation::where('code', $violations)->get();
                }
            } else {
                $relatedViolations = [];
            }
            $tasFile->relatedViolations = $relatedViolations;
        }

        return view('tas.view', compact('tasFiles'));
    }
    public function admitmanage(){
        $officers = ApprehendingOfficer::select('officer', 'department')->get();
        // dd($recentViolationsToday[1]);
        $violations = TrafficViolation::orderBy('code', 'asc')->get();
        // return view('tas.manage',compact('officers','violations'));
        return view('admitted.manage', compact('officers','violations'));
    }
    public function admitview(){
        // Retrieve admitted data
        $admitted = Admitted::all()->sortByDesc('resolution_no');

        foreach ($admitted as $admit) {
            $violations = json_decode($admit->violation);
            $officerName = $admit->apprehending_officer;
                $officer = ApprehendingOfficer::firstOrCreate(['officer' => $officerName]);
                $admit->relatedofficer = $officer;
            if ($violations) {
                $relatedViolations = TrafficViolation::whereIn('id', $violations)->get();
            } else {
                // If $violations is null, set $relatedViolations to an empty collection
                $relatedViolations = [];
            }

            $admit->relatedViolations = $relatedViolations;
        }

        $pageSize = 15; // Define the default page size
        $admitted = Admitted::all()->sortByDesc('resolution_no');
        $officers = collect();
        
        foreach ($admitted as $admit) {
            $officerName = $admit->apprehending_officer;
            $officersForFile = ApprehendingOfficer::where('officer', $officerName)->get();
            $officers = $officers->merge($officersForFile);
            $admit->relatedofficer = $officersForFile;
            
            if (is_string($admit->remarks)) {
                $remarks = json_decode($admit->remarks, true);
                if ($remarks === null) {
                    $remarks = [];
                }
            } else if (is_array($admit->remarks)) {
                $remarks = $admit->remarks;
            } else {
                $remarks = [];
            }
            $admit->remarks = $remarks;
    
            $violations = json_decode($admit->violation);
            if ($violations) {
                if (is_array($violations)) {
                    $relatedViolations = TrafficViolation::whereIn('code', $violations)->get();
                } else {
                    $relatedViolations = TrafficViolation::where('code', $violations)->get();
                }
            } else {
                $relatedViolations = [];
            }
            $admit->relatedViolations = $relatedViolations;
        }
    
        return view('admitted.view', compact('admitted'));
    }
    public function saveRemarks(Request $request) {
        $request->validate([
            'remarks' => 'required|string',
            'tas_file_id' => 'required|exists:tas_files,id',
        ]);
    
        try {
            $id = $request->input('tas_file_id');
            $remarks = $request->input('remarks');
            $tasFile = TasFile::findOrFail($id);
            $existingRemarks = json_decode($tasFile->remarks, true) ?? [];
            $timestamp = Carbon::now('Asia/Manila')->format('g:ia m/d/y');
            $newRemark = $remarks . ' - ' . $timestamp .' - '. Auth::user()->fullname;
            $existingRemarks[] = $newRemark;
            $updatedRemarksJson = json_encode($existingRemarks);
    
            DB::beginTransaction();
            $tasFile->update(['remarks' => $updatedRemarksJson]);
            DB::commit();
    
            // Send back a response with 201 Created status code
            // Here, we are also returning a success message in the response body
            return response()->json(['message' => 'Remarks saved successfully.'], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error('Error saving remarks: ' . $th->getMessage());
            return response()->json(['error' => $th->getMessage()], 500); // You can return a different error status code if needed
        }
    }
    //admitted remarks
    public function admitremark(Request $request){
        $request->validate([
            'remarks' => 'required|string',
            'tas_file_id' => 'required|exists:tas_files,id',
        ]);
    
        try {
            $id = $request->input('tas_file_id');
            $remarks = $request->input('remarks');
            $tasFile = admitted::findOrFail($id);
            $existingRemarks = json_decode($tasFile->remarks, true) ?? [];
            $timestamp = Carbon::now('Asia/Manila')->format('g:ia m/d/y');
            $newRemark = $remarks . ' - ' . $timestamp .' - '. Auth::user()->fullname;
            $existingRemarks[] = $newRemark;
            $updatedRemarksJson = json_encode($existingRemarks);
    
            DB::beginTransaction();
            $tasFile->update(['remarks' => $updatedRemarksJson]);
            DB::commit();
    
            // Send back a response with 201 Created status code
            // Here, we are also returning a success message in the response body
            return response()->json(['message' => 'Remarks saved successfully.'], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error('Error saving remarks: ' . $th->getMessage());
            return response()->json(['error' => $th->getMessage()], 500); // You can return a different error status code if needed
        }
    }
    public function submitForm(Request $request){
        try {
            $validatedData = $request->validate([
                'case_no' => 'required|string',
                'top' => 'nullable|string',
                'driver' => 'required|string',
                'apprehending_officer' => 'required|string',
                'violation' => 'required|string',
                'transaction_no' => 'nullable|string',
                'date_received' => 'required|date',
                'contact_no' => 'required|string',
                'plate_no' => 'required|string',
                'status' => 'required|string|in:closed,in-progress,settled,unsettled',
                'file_attachment' => 'nullable|array',
                'file_attachment.*' => 'nullable|file|max:5120',
                'typeofvehicle' => 'required|string', // Add validation for typeofvehicle
            ]);

            DB::beginTransaction();

            $existingTasFile = TasFile::where('case_no', $validatedData['case_no'])->first();

            if (!$existingTasFile) {
                $tasFile = new TasFile([
                    'case_no' => $validatedData['case_no'],
                    'top' => $validatedData['top'],
                    'driver' => $validatedData['driver'],
                    'apprehending_officer' => $validatedData['apprehending_officer'],
                    'violation' => json_encode(explode(', ', $validatedData['violation'])),
                    'transaction_no' => $validatedData['transaction_no'] ? "TRX-LETAS-" . $validatedData['transaction_no'] : null,
                    'plate_no' => $validatedData['plate_no'],
                    'date_received' => $validatedData['date_received'],
                    'contact_no' => $validatedData['contact_no'],
                    'status' => $validatedData['status'],
                    'typeofvehicle' => $validatedData['typeofvehicle'], // Add typeofvehicle field to be saved
                ]);

                if ($request->hasFile('file_attachment')) {
                    $filePaths = [];
                    $cx = 1;
                    foreach ($request->file('file_attachment') as $file) {
                        $x = "CS-".$validatedData['case_no'] . "_documents_" . $cx . "_";
                        $fileName = $x . time();
                        $file->storeAs('attachments', $fileName, 'public');
                        $filePaths[] = 'attachments/' . $fileName;
                        $cx++;
                    }
                    $tasFile->file_attach = json_encode($filePaths);
                }

                $tasFile->save();
            } else {
                return redirect()->back()->with('error', 'Case no. already exists.');
            }

            DB::commit();

            return redirect()->back()->with('success', 'Form submitted successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function admittedsubmit(Request $request) {
         // dd($request->all());
         try {
            $validatedData = $request->validate([
                'top' => 'nullable|string',
                'resolution_no' => 'nullable|string',
                'driver' => 'required|string',
                'apprehending_officer' => 'required|string',
                'violation' => 'required|string',
                'transaction_no' => 'nullable|string',
                'contact_no' => 'required|string',
                'plate_no' => 'required|string',
                'date_received' => 'required|date',
                'file_attachment' => 'nullable|array',
                'file_attachment.*' => 'nullable|file|max:5120',
            ]);
            DB::beginTransaction();
            $currentYear = date('Y');
            $existingadmitted = admitted::where('resolution_no', $validatedData['resolution_no'])->first();
            if (!$existingadmitted) {
                $admitted = new admitted([
                    'resolution_no' => 'CS-' . $currentYear .'-'. $validatedData['resolution_no'],
                    'top' => $validatedData['top'],
                    'driver' => $validatedData['driver'],
                    'apprehending_officer' => $validatedData['apprehending_officer'],
                    'violation' => json_encode(explode(', ', $validatedData['violation'])),
                    'date_received' => $validatedData['date_received'],
                    'transaction_no' => $validatedData['transaction_no'] ? "TRX-LETAS-" . $validatedData['transaction_no'] : null,
                    'plate_no' => $validatedData['plate_no'],
                    'contact_no' => $validatedData['contact_no'],

                ]);

                if ($request->hasFile('file_attachment')) {
                    $filePaths = [];
                    $cx = 1;
                    foreach ($request->file('file_attachment') as $file) {
                        $x = $validatedData['resolution_no'] . "_documents_" . $cx . "_";
                        $fileName = $x . time();
                        $file->storeAs('attachments', $fileName, 'public');
                        $filePaths[] = 'attachments/' . $fileName;
                        $cx++;
                    }
                    $admitted->file_attach = json_encode($filePaths);
                }

                $admitted->save();
            } else {
                return redirect()->back()->with('error', 'resolution no. already exists.');
            }
            DB::commit();
            return redirect()->back()->with('success', 'Form submitted successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function profile(Request $request){
        $userId = $request->id;
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('dashboard')->with('error', 'User not found.');
        }
        return view('profile', ['user' => $user]);
    }
    public function edit($id){
        $user = User::findOrFail($id);
        return view('edit_profile', compact('user'));
    }
    public function update(Request $request, $id){
        try {
            $request->validate([
                'fullname' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'role' => 'nullable|string|max:255',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6144'
            ]);
            $user = User::findOrFail($id);
            if ($request->hasFile('profile_picture')) {
                $profilePicture = $request->file('profile_picture');
                $filename = Auth::user()->id . '_' . $profilePicture->getClientOriginalName();
                // Store the uploaded file in storage/app/public/profiles directory
                $path = $profilePicture->storeAs('public/profiles', $filename);
            }
            $user->update([
                'fullname' => $request->input('fullname'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
            ]);

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    } 
    public function change($id){
        $user = User::findOrFail($id);
        return view('change_password', compact('user'));
    }
    public function updatePassword(Request $request){
        try {
            $user = Auth::user();
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password does not match.');
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return back()->with('success', 'Password updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function management(){
        $users = User::all();

        return view('user_management', ['users' => $users]);
    }
    public function userdestroy(User $user){
        $user->delete();

        return redirect()->route('user_management')->with('success', 'User deleted successfully');
    }
    public function add_user(){
        return view('add-user');
    }
    public function store_user(Request $request){
        try {
            // Validate the incoming request data
            $request->validate([
                'fullname' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            // Begin a database transaction
            DB::beginTransaction();


            $user = new User([
                'fullname' => $request->input('fullname'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'email_verified_at' => now(),
                'password' => bcrypt($request->input('password')),
            ]);


            $user->save();


            DB::commit();


            return redirect()->route('user_management')->with('success', 'User created successfully');
        } catch (\Exception $e) {

            DB::rollBack();


            Log::error('Error creating user: ' . $e->getMessage());


            return redirect()->back()->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }
    public function violationadd(){
        return view('ao.addvio');
    }
    public function officergg(){
        return view('ao.addoffi');
    }    
    public function editoffi(){

        $officers = ApprehendingOfficer::all();

        // dd($officers[1]);
        return view('ao.editoffi', compact('officers'));
    }
    public function edivio(){

        $violations = TrafficViolation::orderBy('code', 'asc')->get();

        // dd($officers[1]);
        return view('ao.editvio', compact('violations'));
    }
    //add officer
    public function save_offi(Request $request){
        try {
            $request->validate([
                'officer' => 'required|string',
                'department' => 'required|string',
            ]);

            // Check if the officer already exists
            $existingOfficer = ApprehendingOfficer::where('officer', $request->input('officer'))
                ->where('department', $request->input('department'))
                ->first();

            if ($existingOfficer) {
                return redirect()->back()->with('error', 'Officer already exists.');
            }

            DB::beginTransaction();
            $user = new ApprehendingOfficer([
                'officer' => $request->input('officer'),
                'department' => $request->input('department'),
            ]);

            $user->save();

            DB::commit();

            return redirect()->back()->with('success', 'Officer created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Officer: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error creating Officer: ' . $e->getMessage());
        }
    }
    // add violation//
    public function addvio(Request $request){
        try {
            $request->validate([
                'code' => 'string',
                'violation' => 'string',
            ]);


            DB::beginTransaction();
            $user = new TrafficViolation([
                'code' => $request->input('code'),
                'violation' => $request->input('violation'),
                ]);


            $user->save();

            DB::commit();

            return redirect()->back()->with('success', 'Violation created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Violation: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error creating Violation: ' . $e->getMessage());
        }
    }
    public function updateTas(Request $request, $id) {
        try {
            // Find the violation by ID
            $violation = TasFile::findOrFail($id);

            // Validate the incoming request data
            $validatedData = $request->validate([
                'case_no' => 'nullable|string|max:255',
                'top' => 'nullable|string|max:255',
                'driver' => 'nullable|string|max:255',
                'apprehending_officer' => 'nullable|string|max:255',
                'violation' => 'nullable|array',
                'transaction_no' => 'nullable|string|max:255',
                'date_received' => 'nullable|date',
                'plate_no' => 'nullable|string|max:255',
                'contact_no' => 'nullable|string|max:255',
                'remarks.*.text' => 'nullable|string',
                'file_attach_existing.*' => 'nullable|file|max:10240', // Added file validation rules
            ]);

       // Attach files
if ($request->hasFile('file_attach_existing')) {
    // Retrieve existing file attachments and decode them
    $existingFilePaths = json_decode($violation->file_attach, true) ?? [];
    
    $cx = count($existingFilePaths) + 1;
    foreach ($request->file('file_attach_existing') as $file) {
        // Check if the file was actually uploaded
        if ($file->isValid()) {
            $x = "CS-".$violation->case_no . "_documents_" . $cx . "_";
            $fileName = $x . time();
            $file->storeAs('attachments', $fileName, 'public');
            $existingFilePaths[] = 'attachments/' . $fileName; // Append the new file path
            $cx++;
        } else {
            // File upload failed, return an error response
            return back()->with('error', 'Failed to upload files.');
        }
    }
    $violation->file_attach = json_encode($existingFilePaths); // Save the updated array
}


            // Process remarks
            if (isset($validatedData['remarks']) && is_array($validatedData['remarks'])) {
                $remarksArray = [];
                foreach ($validatedData['remarks'] as $remark) {
                    $remarksArray[] = $remark['text'];
                }
                $validatedData['remarks'] = json_encode($remarksArray);
            }

            // Merge new violations into existing violations array
            if (!empty($validatedData['violation'])) {
                $existingViolations = json_decode($violation->violation, true) ?? [];
                $newViolations = array_filter($validatedData['violation'], function ($value) {
                    return $value !== null;
                });
                $validatedData['violation'] = json_encode(array_unique(array_merge($existingViolations, $newViolations)));
            }

            // Update the violation with validated data
            $violation->update($validatedData);

            // If new violations were added, add them to the TasFile model
            if (!empty($newViolations)) {
                foreach ($newViolations as $newViolation) {
                    $violation->addViolation($newViolation);
                }
                // Refresh the model after adding new violations
                $violation = TasFile::findOrFail($id);
            }

            return back()->with('success', 'Violation updated successfully')->with('status', 201);

        } catch (\Exception $e) {
            // Log the error
            Log::error('Error updating Violation: ' . $e->getMessage());

            // Set error message
            return back()->with('error', 'Error updating Violation: ' . $e->getMessage());
        }
    }
    public function updateStatus(Request $request, $id){
        try {
            // Log the request data for debugging
            \Log::info('Request data: ', $request->all());

            $tasFile = TasFile::findOrFail($id);

            // Log the received status for debugging
            \Log::info('Received status: ' . $request->status);

            $tasFile->status = $request->status;
            $tasFile->save();

            return redirect()->back()->with('success', 'Status updated successfully.');
        } catch (\Exception $e) {
            // Log any errors for debugging
            \Log::error('Error updating status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }
    public function finishCase(Request $request, $id){
        $tasFile = TasFile::findOrFail($id);
        $tasFile->status = 'closed';
        $tasFile->fine_fee = $request->fine_fee;
        $tasFile->save();

        return redirect()->back()->with('success', 'Case finished successfully.');
    }
    public function printsub(Request $request, $id){
        $tasFile = TasFile::findOrFail($id);
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
        $status = $request->input('details');
        switch ($status) {
            case "subpeona":
                return view('sub.print', compact('tasFile', 'compactData'));
            case "motionrelease1":
                return view('sub.motionreleasep1', compact('tasFile', 'compactData'));
            case "motionrelease2":
                return view('sub.motionreleasep2', compact('tasFile', 'compactData'));
            default:
                // Handle default case if necessary
                return view('sub.print', compact('tasFile', 'compactData'));
        }
    }
    function deleteTas($id){
        try {
            $violation = TasFile::findOrFail($id);
            $violation->delete();
            return redirect()->back()->with('success', 'Violation deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting Violation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error deleting Violation: ' . $e->getMessage());
        }
    }
    public function analyticsDash(){
        // Fetch the data from the database
        $data = TasFile::select(
            DB::raw('MONTH(date_received) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy(DB::raw('MONTH(date_received)'))
        ->get();

        // Define colors for each month
        $colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff', '#ff8000', '#8000ff', '#0080ff', '#ff0080', '#80ff00', '#00ff80'];

        // Prepare the data for the chart
        $months = [];
        $counts = [];
        $backgroundColors = [];
        foreach ($data as $index => $item) {
            $monthDateTime = \DateTime::createFromFormat('!m', $item->month);
            if ($monthDateTime !== false) { // Check if DateTime object was created successfully
                $months[] = $monthDateTime->format('M'); // Convert month number to month name
                $counts[] = $item->count;
                $backgroundColors[] = $colors[$index % count($colors)]; // Assign color based on index
            }
        }

        // Pass data to the view using compact
        return view('analytics', compact('months', 'counts', 'backgroundColors'));
    }
    public function updateContest(){
        // Fetch all traffic violations
        
        
        // Fetch recent TasFiles ordered by case number descending
        $recentViolationsToday = TasFile::orderBy('case_no', 'desc')->get();
        
        // Fetch all codes (assuming TrafficViolation model provides codes)
        $violation = TrafficViolation::all();
        
        // Prepare a collection for officers
        $officers = collect();
       
        
        // Iterate through each TrafficViolation record
        foreach ($recentViolationsToday as $violation) {
            // Extract the name of the apprehending officer for the current TrafficViolation
            $officerName = $violation->apprehending_officer;
    
            // Query the ApprehendingOfficer model for officers with the given name
            $officersForFile = ApprehendingOfficer::where('officer', $officerName)->get();
    
            // Merge the officers into the collection
            $officers = $officers->merge($officersForFile);
    
 
        }
  
        // Pass data to the view, including the new variable $violationData
        return view('tas.edit', compact('recentViolationsToday', 'violation', 'officers'));
    }
    public function updateAdmitted(){
        // Fetch all traffic violations
        
        
        // Fetch recent TasFiles ordered by case number descending
        $recentViolationsToday = Admitted::all()->sortByDesc('resolution_no');
        
        // Fetch all codes (assuming TrafficViolation model provides codes)
        $codes = TrafficViolation::all();
        
        // Prepare a collection for officers
        $officers = collect();
       
        
        // Iterate through each TrafficViolation record
        foreach ($recentViolationsToday as $violation) {
            // Extract the name of the apprehending officer for the current TrafficViolation
            $officerName = $violation->apprehending_officer;
    
            // Query the ApprehendingOfficer model for officers with the given name
            $officersForFile = ApprehendingOfficer::where('officer', $officerName)->get();
    
            // Merge the officers into the collection
            $officers = $officers->merge($officersForFile);
    
 
        }
  
        // Pass data to the view, including the new variable $violationData
        return view('admitted.edit', compact('recentViolationsToday', 'codes', 'officers' ));
    }
    public function historyIndex() {

        return view('history');
    }
    public function fetchRemarks($id){
        $tasFile = TasFile::findOrFail($id);
        $remarks = json_decode($tasFile->remarks);

        return response()->json(['remarks' => $remarks]);
    }
    public function updateoffi(Request $request, $id){
        try {
            // Validate incoming request
            $request->validate([
                'officer' => 'required|string',
                'department' => 'required|string',
            ]);

            // Update officer details
            $officer = ApprehendingOfficer::findOrFail($id);
            $officer->officer = $request->input('officer');
            $officer->department = $request->input('department');
            $officer->save();

            // Redirect back with success message
            return back()->with('success', 'Officer details updated successfully.');
        } catch (ModelNotFoundException $e) {
            // Handle case where officer with $id is not found
            return back()->with('error', 'Officer not found.');
        } catch (ValidationException $e) {
            // Handle validation errors
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            // Handle other unexpected errors
            return back()->with('error', 'Failed to update officer details. Please try again.');
        }
    }
    public function updateviolation(Request $request, $id){
        try {
            // Validate incoming request
            $request->validate([
                'officer' => 'required|string',
                'department' => 'required|string',
            ]);

            // Update officer details
            $officer = ApprehendingOfficer::findOrFail($id);
            $officer->officer = $request->input('officer');
            $officer->department = $request->input('department');
            $officer->save();

            // Redirect back with success message
            return back()->with('success', 'Officer details updated successfully.');
        } catch (ModelNotFoundException $e) {
            // Handle case where officer with $id is not found
            return back()->with('error', 'Officer not found.');
        } catch (ValidationException $e) {
            // Handle validation errors
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            // Handle other unexpected errors
            return back()->with('error', 'Failed to update officer details. Please try again.');
        }
    }
    public function detailstasfile(Request $request, $id){
        try {
            // Find the TasFile by its ID or throw a ModelNotFoundException
            $tasFile = TasFile::findOrFail($id);

            // Retrieve related ApprehendingOfficers
            $relatedOfficers = ApprehendingOfficer::where('officer', $tasFile->apprehending_officer)->get();

            // Retrieve related TrafficViolations
            $violations = json_decode($tasFile->violation, true);
            $relatedViolations = [];
            if ($violations) {
                $relatedViolations = TrafficViolation::whereIn('code', $violations)->get();
            }
            
            $remarks = json_decode($tasFile->remarks);
            // Check if $remarks is an array
            if (is_array($remarks)) {
                $remarks = array_reverse($remarks);
            } else {
                // If $remarks is not an array, set it to an empty array
                $remarks = [];
            }
            // dd($remarks);
            // Return the view with TasFile and related data
            return view('tas.detailsview', compact('tasFile', 'relatedOfficers', 'relatedViolations', 'remarks'));

        } catch (ModelNotFoundException $e) {
            // Handle case where TasFile with $id is not found
            return response()->view('errors.404', [], 404);
        }
    }
    public function detailsedit(Request $request, $id) {
        try {
            // Find the TasFile by its ID or throw a ModelNotFoundException
            $recentViolationsToday = TasFile::findOrFail($id);
    
            // Retrieve all Traffic Violations ordered by code ascending
            $violationz = TrafficViolation::orderBy('code', 'asc')->get();
    
            // Prepare a collection for officers
            $officers = collect();
    
            // Get the apprehending officer name from the TasFile
            $officerName = $recentViolationsToday->apprehending_officer;
    
            // Query the ApprehendingOfficer model for officers with the given name
            $officersForFile = ApprehendingOfficer::where('officer', $officerName)->get();
    
            // Merge the officers into the collection
            $officers = $officers->merge($officersForFile);
    
            // Decode remarks if they are JSON-encoded
            $remarks = json_decode($recentViolationsToday->remarks, true);
            
            // Check if $remarks is an array and reverse it if so
            if (is_array($remarks)) {
                $remarks = array_reverse($remarks);
            } else {
                // If $remarks is not an array or JSON decoding failed, set it to an empty array
                $remarks = [];
            }
    
            // Pass data to the view
            return view('tas.detailsedit', compact('recentViolationsToday', 'officers', 'violationz', 'remarks'));
    
        } catch (ModelNotFoundException $e) {
            // Handle the case where the TasFile with the specified ID is not found
            return response()->view('errors.404', [], 404);
        }
    }
    
    public function detailsadmitted(Request $request, $id){
        try {
            // Find the TasFile by its ID or throw a ModelNotFoundException
            $admitted = admitted::findOrFail($id);

            // Retrieve related ApprehendingOfficers
            $relatedOfficers = ApprehendingOfficer::where('officer', $admitted->apprehending_officer)->get();

            // Retrieve related TrafficViolations
            $violations = json_decode($admitted->violation, true);
            $relatedViolations = [];
            if ($violations) {
                $relatedViolations = TrafficViolation::whereIn('code', $violations)->get();
            }
            
            $remarks = json_decode($admitted->remarks);
            // Check if $remarks is an array
            if (is_array($remarks)) {
                $remarks = array_reverse($remarks);
            } else {
                // If $remarks is not an array, set it to an empty array
                $remarks = [];
            }
            // dd($remarks);
            // Return the view with TasFile and related data
            return view('admitted.detailsview', compact('admitted', 'relatedOfficers', 'relatedViolations', 'remarks'));

        } catch (ModelNotFoundException $e) {
            // Handle case where TasFile with $id is not found
            return response()->view('errors.404', [], 404);
        }
    }
    public function finishtasfile(Request $request, $id){
        try {
            // Find the TasFile by its ID or throw a ModelNotFoundException
            $tasFile = TasFile::findOrFail($id);

            // Retrieve related ApprehendingOfficers
            $relatedOfficers = ApprehendingOfficer::where('officer', $tasFile->apprehending_officer)->get();

            // Retrieve related TrafficViolations
            $violations = json_decode($tasFile->violation, true);
            $relatedViolations = [];
            if ($violations) {
                $relatedViolations = TrafficViolation::whereIn('code', $violations)->get();
            }
            
            $remarks = json_decode($tasFile->remarks);
            // Check if $remarks is an array
            if (is_array($remarks)) {
                $remarks = array_reverse($remarks);
            } else {
                // If $remarks is not an array, set it to an empty array
                $remarks = [];
            }
            // dd($remarks);
            // Return the view with TasFile and related data
            return view('tas.detailsview', compact('tasFile', 'relatedOfficers', 'relatedViolations', 'remarks'));

        } catch (ModelNotFoundException $e) {
            // Handle case where TasFile with $id is not found
            return response()->view('errors.404', [], 404);
        }
    }
    public function fetchFinishData($id){
        try {
            // Find the TasFile by its ID or throw a ModelNotFoundException
            $tasFile = TasFile::findOrFail($id);
    
            // Retrieve related ApprehendingOfficers
            $relatedOfficers = ApprehendingOfficer::where('officer', $tasFile->apprehending_officer)->get();
    
            // Retrieve related TrafficViolations
            $violations = json_decode($tasFile->violation, true);
            $relatedViolations = [];
            if ($violations) {
                $relatedViolations = TrafficViolation::whereIn('code', $violations)->get();
            }
            
            // Check if $tasFile->remarks is already an array
            $remarks = is_array($tasFile->remarks) ? $tasFile->remarks : [];
    
            // Reverse the array if it's an array
            $remarks = array_reverse($remarks);
    
            // Return the view with TasFile and related data
            return view('tas.detailsview', compact('tasFile', 'relatedOfficers', 'relatedViolations', 'remarks'));
    
        } catch (ModelNotFoundException $e) {
            // Handle case where TasFile with $id is not found
            return response()->view('errors.404', [], 404);
        }
    }
    public function removeAttachment(Request $request, $id) {
        try {
            $tasFile = TasFile::findOrFail($id);
            $attachmentToRemove = $request->input('attachment');
    
            if ($attachmentToRemove) {
                $attachments = json_decode($tasFile->file_attach, true) ?? [];
    
                // Check if the attachment exists in the array
                if (($key = array_search($attachmentToRemove, $attachments)) !== false) {
                    unset($attachments[$key]);
                    $tasFile->file_attach = json_encode(array_values($attachments)); // Reindex array and encode back to JSON
                    $tasFile->save();
    
                    // Optionally, delete the file from the storage
                    Storage::delete($attachmentToRemove);
    
                    return response()->json(['success' => 'Attachment removed successfully.']);
                } else {
                    return response()->json(['error' => 'Attachment not found in the list.'], 404);
                }
            } else {
                return response()->json(['error' => 'Attachment parameter is missing.'], 400);
            }
        } catch (\Exception $e) {
            // Log the error or handle it as per your application's needs
            return response()->json(['error' => 'Failed to remove attachment.'], 500);
        }
    }
    
    public function UPDATEVIO(Request $request, $id){
        $tasFile = TasFile::findOrFail($id);
        $violationIndex = $request->input('index');
        $newViolation = $request->input('violation');

        // Retrieve existing violations
        $violations = json_decode($tasFile->violation, true) ?? [];

        if (isset($violations[$violationIndex])) {
            $violations[$violationIndex] = $newViolation;
            $tasFile->violation = json_encode($violations);
            $tasFile->save();
        }

        return response()->json(['message' => 'Violation updated successfully', 'violations' => json_decode($tasFile->violation)]);
    }
    public function DELETEVIO(Request $request, $id) {
        $tasFile = TasFile::findOrFail($id);
        $violationIndex = $request->input('index');

        // Retrieve existing violations
        $violations = json_decode($tasFile->violation, true) ?? [];

        if (isset($violations[$violationIndex])) {
            array_splice($violations, $violationIndex, 1);
            $tasFile->violation = json_encode($violations);
            $tasFile->save();
        }

        return response()->json(['message' => 'Violation deleted successfully', 'violations' => json_decode($tasFile->violation)]);
    }
    public function deleteRemark(Request $request)
    {
        // Retrieve data from AJAX request
        $violationId = $request->input('violation_id');
        $index = $request->input('index');

        // Find the TasFile by violation ID (assuming TasFile is your model)
        try {
            $tasFile = TasFile::findOrFail($violationId);

            // Decode remarks from JSON to array
            $remarks = json_decode($tasFile->remarks, true);

            // Check if remarks exist and if the index is valid
            if (is_array($remarks) && array_key_exists($index, $remarks)) {
                // Remove the remark at the specified index
                unset($remarks[$index]);

                // Encode the updated remarks array back to JSON and update the TasFile
                $tasFile->remarks = json_encode(array_values($remarks)); // Re-index array
                $tasFile->save();

                // Return a success response
                return response()->json(['message' => 'Remark deleted successfully']);
            } else {
                // Return an error response if remark or index is invalid
                return response()->json(['error' => 'Invalid remark index'], 404);
            }
        } catch (\Exception $e) {
            // Return an error response if TasFile is not found or any other exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}