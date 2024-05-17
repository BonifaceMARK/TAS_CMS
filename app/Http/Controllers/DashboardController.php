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
        $violations = TrafficViolation::all();
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

    public function tasView()
    {
        $pageSize = 15; // Define the default page size
        $tasFiles = TasFile::all()->sortByDesc('case_no');
    
        // Initialize a collection to hold related officers
        $officers = collect();
    
        // Iterate through each TasFile record
        foreach ($tasFiles as $tasFile) {
            // Extract the name of the apprehending officer for the current TasFile
            $officerName = $tasFile->apprehending_officer;
            
            // Query the ApprehendingOfficer model for officers with the given name
            $officersForFile = ApprehendingOfficer::where('officer', $officerName)->get();

            $officers = $officers->merge($officersForFile);
            
   
            $tasFile->relatedofficer = $officersForFile;

            $remarks = json_decode($tasFile->remarks);
            
            if (is_array($remarks)) {
                $remarks = array_reverse($remarks);
            } else {
                // If $remarks is not an array, set it to an empty array
                $remarks = [];
            }
            $tasFile->remarks = is_array($remarks) ? $remarks : [];
        }

        foreach ($tasFiles as $tasFile) {

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
        // Fetch TasFile data
        $tF = TasFile::all();
     foreach ($tF as $tasFile) {
        $tasFile->checkCompleteness();
    }

        return view('tas.view', compact('tasFiles'));
    }
    
    
    
    public function admitmanage()
    {
         // Retrieve data: count of traffic violations per plate number
        $trafficData = Admitted::select('violation', DB::raw('COUNT(*) as total'))
                           ->groupBy('violation')
                           ->get();


        $admitteds = Admitted::all(); // Retrieve all admitted cases
        return view('admitted.manage', compact('admitteds','trafficData'));
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

        // Pass the modified admitted data to the view
        return view('admitted.view', compact('admitted'));
    }
    public function saveRemarks(Request $request){
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
            $newRemark = $remarks . ' - ' . $timestamp .' - by '. Auth::user()->fullname;
            $existingRemarks[] = $newRemark;
            $updatedRemarksJson = json_encode($existingRemarks);
        
            DB::beginTransaction();
            $tasFile->update(['remarks' => $updatedRemarksJson]);
            DB::commit();
        
            // Send back a response with JavaScript to close the tab
            $remarksHtml = view('remarksupdate', ['remarks' => $tasFile->remarks])->render();
            return response()->json(['remarks' => $remarksHtml]);
            // return back()->with('success', 'Remarks saved successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error('Error saving remarks: ' . $th->getMessage());
            return back()->withErrors([$th->getMessage()]);
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
            $admitted = admitted::findOrFail($id);
            $existingRemarks = json_decode($admitted->remarks, true) ?? [];
            $timestamp = Carbon::now('Asia/Manila')->format('g:ia m/d/y');
            $newRemark = $remarks . ' - ' . $timestamp .' - by '. Auth::user()->fullname;
            $existingRemarks[] = $newRemark;
            $updatedRemarksJson = json_encode($existingRemarks);
            DB::beginTransaction();
            $admitted->update(['remarks' => $updatedRemarksJson]);
            DB::commit();
            return redirect()->back()->with('success', 'Remarks Updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error('Error saving remarks: ' . $th->getMessage());
            return back()->with('error', 'Failed to save remarks. Please try again later.');
        }
    }
    public function submitForm(Request $request)
    {
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
                        $x = $validatedData['case_no'] . "_documents_" . $cx . "_";
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
    
    public function admittedsubmit(Request $request) // admitted
    {
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
    public function updateAdmitted(Request $request){
        $data = $request->only([
            'resolution_no',
            'top',
            'name',
            'violation',
            'transaction_no',
            'transaction_date',
            'plate_no',
            'contact_no',
            'remarks',
            'file_attach',
        ]);

        try {
            // Find the admitted case by ID
            $admitted = Admitted::findOrFail($request->id);

            // Update the admitted case with the provided data
            $admitted->update($data);

            return response()->json(['message' => 'Admitted case updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update admitted case', 'message' => $e->getMessage()], 500);
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
            ]);
            $user = User::findOrFail($id);
            $user->update([
                'fullname' => $request->input('fullname'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
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
        return view('addvio');
    }
    public function officergg(){ 
        return view('addoffi');
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
    public function updateTas(Request $request, $id)
    {
        try {
            // Find the violation by ID
            $violation = TasFile::findOrFail($id);
            
            // Validate the incoming request data
            $validatedData = $request->validate([
                'case_no' => 'nullable|string|max:255',
                'top' => 'nullable|string|max:255',
                'driver' => 'nullable|string|max:255',
                'apprehending_officer' => 'nullable|string|max:255',
                'violation' => 'nullable|array', // Changed to array, as we expect multiple violations
                'transaction_no' => 'nullable|string|max:255',
                'date_received' => 'nullable|date',
                'plate_no' => 'nullable|string|max:255',
                'contact_no' => 'nullable|string|max:255',
                'remarks.*' => 'nullable|string',
                'delete_file.*' => 'nullable|string', // Added validation for delete_file array
                'file_attach.*' => 'nullable|file|max:10240', // Adjust max file size as needed
            ]);
            
            // If 'remarks' is set and is an array, join the array elements into a single string
            if (isset($validatedData['remarks']) && is_array($validatedData['remarks'])) {
                $validatedData['remarks'] = implode(', ', $validatedData['remarks']);
            }
        
            // Trim the 'remarks' field only if it is a string
            if (isset($validatedData['remarks']) && is_string($validatedData['remarks'])) {
                $validatedData['remarks'] = trim($validatedData['remarks']);
            }
            
            // Check if file deletion option is selected
            if ($request->has('delete_file')) {
                // Get the checked attachments to delete
                $attachmentsToDelete = $validatedData['delete_file'] ?? [];
                
                // Remove the checked attachments from the current file attachments
                $attachments = json_decode($violation->file_attach, true) ?? [];
                $newAttachments = array_diff($attachments, $attachmentsToDelete);
                
                // Update the file_attach attribute in the database
                $violation->update(['file_attach' => json_encode($newAttachments)]);
                
                // Append deletion action to history
                foreach ($attachmentsToDelete as $attachment) {
                    $history[] = [
                        'action' => 'DELETE_ATTACHMENT',
                        'user_id' => auth()->id(), // Assuming you have user authentication
                        'username' => auth()->user()->username,
                        'timestamp' => now(),
                        'attachment' => $attachment,
                    ];
                }
            }
            
            // Check if new attachments are uploaded
            if ($request->hasFile('file_attach')) {
                // Handle file uploads and append new attachments to existing ones
                $newAttachments = [];
                foreach ($request->file('file_attach') as $file) {
                    $filename = $validatedData['case_no'] . "_documents_" . time() . "_" . $file->getClientOriginalName();
                    $file->storeAs('attachments', $filename, 'public'); // Store in public/attachments directory
                    $newAttachments[] = 'attachments/' . $filename; // Store relative path in database
                }
                $currentAttachments = json_decode($violation->file_attach, true) ?? [];
                $allAttachments = array_merge($currentAttachments, $newAttachments);
                $validatedData['file_attach'] = json_encode($allAttachments);
                
                // Append addition action to history
                foreach ($newAttachments as $attachment) {
                    $history[] = [
                        'action' => 'ADD_ATTACHMENT',
                        'user_id' => auth()->id(), // Assuming you have user authentication
                        'username' => auth()->user()->username,
                        'timestamp' => now(),
                        'attachment' => $attachment,
                    ];
                }
            }
            
            // Merge new violations into existing violations array
            if (!empty($validatedData['violation'])) {
                $existingViolations = json_decode($violation->violation, true) ?? [];
                $newViolations = array_filter($validatedData['violation'], function($value) {
                    return $value !== null;
                });
                $validatedData['violation'] = array_unique(array_merge($existingViolations, $newViolations));
            }
            
            // Capture changes
            $changes = [];
            foreach ($validatedData as $field => $newValue) {
                if ($violation->$field !== $newValue) {
                    $changes[$field] = [
                        'old_value' => $violation->$field,
                        'new_value' => $newValue,
                    ];
                }
            }
            
            // Append new changes to existing history
            $history = $violation->history ?? [];
            if (isset($history)) {
                $history[] = [
                    'action' => 'EDIT',
                    'user_id' => auth()->id(), // Assuming you have user authentication
                    'username' => auth()->user()->username,
                    'timestamp' => now(),
                    'changes' => $changes,
                ];
            }
            
            // Update the violation with validated data
            $violation->update($validatedData);
            
            // Save updated history along with violation
            $violation->history = $history;
            $violation->save();
        
            // Set success message
            return back()->with('success', 'Violation updated successfully');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error updating Violation: ' . $e->getMessage());
        
            // Set error message
            return back()->with('error', 'Error updating Violation: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
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
    
    
    public function finishCase(Request $request, $id)
    {
        $tasFile = TasFile::findOrFail($id);
        $tasFile->status = 'closed';
        $tasFile->fine_fee = $request->fine_fee;
        $tasFile->save();

        return redirect()->back()->with('success', 'Case finished successfully.');
    }
    
    public function printsub($id)
    {
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
            // List of holidays, format: 'MM-DD' or 'YYYY-MM-DD'
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
            '10-31', // Halloween
            '05-14', // Additional holiday declared by the government
            '11-15', // Regional holiday
        ];
        // Get the current date and format it as "Month Day, Year"
        $startDate = $changes->date_received; // Example output: "May 6, 2024"
        

        // Add the specified number of days
        
        $date = new DateTime($startDate);
        $numDays = 4;
        $date->modify("+" . $numDays . " days");
        $newDate = $date->format('F j, Y');
        while ($numDays > 0) {
            $date->modify('+1 day');
            if ($date->format('N') >= 6 || in_array($date->format('m-d'), $holidays)) {
                continue; 
            }
            
            $numDays--;
        }
        $endDate = $date->format('F j, Y');
        $compactData = [
            'changes' => $changes,
            'officers' => $officers,
            'relatedViolations' => $relatedViolations,
            'date' => $newDate,
            'hearing' => $endDate,
        ];
        // dd($compactData);
        return view('sub.print', compact('tasFile', 'compactData'));
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
    public function updateContest()
    {
        // Fetch all traffic violations
        $violations = TrafficViolation::all();
        
        // Fetch recent TasFiles ordered by case number descending
        $recentViolationsToday = TasFile::orderBy('case_no', 'desc')->get();
        
        // Fetch all codes (assuming TrafficViolation model provides codes)
        $codes = TrafficViolation::all();
        
        // Prepare a collection for officers
        $officers = collect();
        
        // Iterate through each TrafficViolation record
        foreach ($violations as $violation) {
            // Extract the name of the apprehending officer for the current TrafficViolation
            $officerName = $violation->apprehending_officer;
        
            // Query the ApprehendingOfficer model for officers with the given name
            $officersForFile = ApprehendingOfficer::where('officer', $officerName)->get();
        
            // Merge the officers into the collection
            $officers = $officers->merge($officersForFile);
        
            // Decode the violation data if it's stored as JSON
            $violationData = json_decode($violation->violation, true);
        
            // Assign the decoded violation data back to the violation object
            $violation->violationData = $violationData;
        }
        
        // Pass data to the view
        return view('tas.edit', compact('recentViolationsToday', 'violations', 'codes', 'officers'));
    }
    
    public function historyIndex()
    {
      
        return view('history');
    }

    public function editAdmit()
    {
        
        return view('admitted.edit');
    }
    public function fetchRemarks($id){
        $tasFile = TasFile::findOrFail($id);
        $remarks = json_decode($tasFile->remarks);

        return response()->json(['remarks' => $remarks]);
    }
  
}

