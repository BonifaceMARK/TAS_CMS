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
use App\Models\TrafficViolation;
use App\Models\fileviolation;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;



class DashboardController extends Controller
{
    public function indexa()
    {
        // Fetch revenue for this month
        $revenueThisMonth = TasFile::whereMonth('created_at', now())->count();
    
        // Fetch revenue for the previous month
        $previousMonthRevenue = TasFile::whereMonth('created_at', Carbon::now()->subMonth())->count();
    
        // // Calculate the percentage change
        // $percentageChange = $previousMonthRevenue > 0 ? (($revenueThisMonth - $previousMonthRevenue) / $previousMonthRevenue) * 100 : 0;
    
        // $percentageChange = $previousYearCustomers > 0 ? (($customersThisYear - $previousYearCustomers) / $previousYearCustomers) * 100 : 0;

        // Fetch recent activity
        $recentActivity = TasFile::whereDate('created_at', today())->latest()->take(5)->get();
    
        // Fetch sales for today
        $salesToday = TasFile::whereDate('created_at', today())->count();
    
        // Fetch customers for this year
        $customersThisYear = TasFile::whereYear('created_at', now())->count();
    
        // Fetch recent sales for today
        $recentSalesToday = TasFile::whereDate('created_at', today())->latest()->take(5)->get();
    
        // Calculate average violations for the previous week
        $averageSalesLastWeek = TasFile::whereBetween('created_at', [Carbon::now()->subDays(7)->startOfDay(), Carbon::now()->subDays(1)->endOfDay()])
                                ->count() / 7;

        return view('index', compact('recentActivity', 'recentSalesToday', 'salesToday', 'revenueThisMonth', 'customersThisYear', 'averageSalesLastWeek'));
       // return view('index', compact('recentActivity', 'recentSalesToday', 'salesToday', 'revenueThisMonth', 'customersThisYear', 'averageSalesLastWeek','previousYearCustomers', 'previousMonthRevenue', 'percentageChange'));
    }
        public function getRecentViolationsToday()
        {
            $recentViolationsToday = TasFile::orderBy('transaction_date', 'desc')
                ->get();
        
            return $recentViolationsToday;
        }
        
    public function tables()
    {
        return view('layout');
    }

    public function tasManage()
    {
        return view('tas.manage');
    }

    public function tasView()
    {
        $tasFiles = TasFile::paginate(10);

        foreach ($tasFiles as $tasFile) {
            // Decode the JSON data representing violations
            $violations = json_decode($tasFile->violation);
        
            $relatedViolations = TrafficViolation::whereIn('id', $violations)->get();
        
            $tasFile->relatedViolations = $relatedViolations;
        }
        // dd($relatedViolations);
        
        return view('tas.view', compact('tasFiles'));
    }
    public function admitmanage()
    {
        return view('admitted.manage');
    }

    public function admitview()
{
    // Retrieve admitted data
    $admitted = Admitted::paginate(10);
    foreach ($admitted as $admit) {
        $violations = json_decode($admit->violation);
    
        $relatedViolations = TrafficViolation::whereIn('id', $violations)->get();
    
        $admit->relatedViolations = $relatedViolations;
    }

    // Pass the modified admitted data to the view
    return view('admitted.view', compact('admitted'));
}

    public function saveRemarks(Request $request)
    {
        $request->validate([
            'remarks' => 'required|string|max:255',
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
            return redirect()->back()->with('success', 'Remarks Updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error('Error saving remarks: ' . $th->getMessage());
            return back()->with('error', 'Failed to save remarks. Please try again later.');
        }
    }

    public function submitForm(Request $request) // contest manage
    {
        // dd($request->all());
         try {
        $validatedData = $request->validate([
            'case_no' => 'required|string',
            'top' => 'nullable|string',
            'name' => 'required|string',
            'violation' => 'required|string',
            'transaction_no' => 'nullable|string',
            'contact_no' => 'required|string',
            'plate_no' => 'required|string',
            'file_attachment' => 'nullable|array',
            'file_attachment.*' => 'nullable|file|max:5120',
        ]);
        DB::beginTransaction();
        $existingTasFile = TasFile::where('case_no', $validatedData['case_no'])->first();
        if (!$existingTasFile) {
            $tasFile = new TasFile([
                'case_no' => $validatedData['case_no'],
                'top' => $validatedData['top'],
                'name' => $validatedData['name'],
                'violation' => json_encode(explode(', ', $validatedData['violation'])),
                'transaction_no' => $validatedData['transaction_no'] ? "TRX-LETAS-" . $validatedData['transaction_no'] : null,
                'plate_no' => $validatedData['plate_no'],
                'contact_no' => $validatedData['contact_no'],
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
                'name' => 'required|string',
                'violation' => 'required|string',
                'transaction_no' => 'nullable|string',
                'contact_no' => 'required|string',
                'plate_no' => 'required|string',
                'file_attachment' => 'nullable|array',
                'file_attachment.*' => 'nullable|file|max:5120',
            ]);
            DB::beginTransaction();
            $existingadmitted = admitted::where('resolution_no', $validatedData['resolution_no'])->first();
            if (!$existingadmitted) {
                $admitted = new admitted([
                    'resolution_no' => $validatedData['resolution_no'],
                    'top' => $validatedData['top'],
                    'name' => $validatedData['name'],
                    'violation' => json_encode(explode(', ', $validatedData['violation'])),
                    'transaction_no' => $validatedData['transaction_no'] ? "TRX-LETAS-" . $validatedData['transaction_no'] : null,
                    'plate_no' => $validatedData['plate_no'],
                    'contact_no' => $validatedData['contact_no'],
                    
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
public function getChartData()
{
    $tasFiles = TasFile::all();
    $chartData = $tasFiles->map(function ($tasFile) {
        return [
            'name' => $tasFile->violation,
            'data' => [$tasFile->case_no], 
        ];});return response()->json($chartData);
    }

    private function getTodayData()
    {
        $chartData = TasFile::whereDate('created_at', today())->get();
        $formattedData = $this->formatChartData($chartData);
        return $formattedData;
    }

    private function getThisMonthData()
    {
        $chartData = TasFile::whereMonth('created_at', today())->get();
        $formattedData = $this->formatChartData($chartData);

        return $formattedData;
    }

    private function getThisYearData()
    {
        $chartData = TasFile::whereYear('created_at', today())->get();
        $formattedData = $this->formatChartData($chartData);
        return $formattedData;
    }

    private function formatChartData($chartData)
    {
        $formattedData = [
            'categories' => $chartData->pluck('name')->toArray(),
            'series' => [[
                'name' => 'Bar Chart',
                'data' => $chartData->pluck('value')->toArray()
            ]]
        ];

        return $formattedData;
    }



    public function profile(Request $request)
    {
        $userId = $request->id;
        $user = User::find($userId); 
    
        if (!$user) {
            return redirect()->route('dashboard')->with('error', 'User not found.');
        }
        return view('profile', ['user' => $user]);
    }
    public function edit($id)
    {
        $user = User::findOrFail($id); 
        return view('edit_profile', compact('user'));
    }
    public function update(Request $request, $id)
    {
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
    public function change($id)
    {
        $user = User::findOrFail($id); 
        return view('change_password', compact('user'));
    }
    public function updatePassword(Request $request)
    {
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
    public function management()
    {
        $users = User::all(); 

        return view('user_management', ['users' => $users]);
    }
    public function userdestroy(User $user)
    {
        $user->delete();

        return redirect()->route('user_management')->with('success', 'User deleted successfully');
    }
    public function add_user()
    {
        return view('add-user');
    }
    public function store_user(Request $request)
    {
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
    
            // Create the new User instance
            $user = new User([
                'fullname' => $request->input('fullname'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'email_verified_at' => now(),
                'password' => bcrypt($request->input('password')),
            ]);
    
            // Save the user to the database
            $user->save();
    
            // Commit the transaction if everything is successful
            DB::commit();
    
            // Redirect back with success message
            return redirect()->route('user_management')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            DB::rollBack();
    
            // Log the exception for debugging
            Log::error('Error creating user: ' . $e->getMessage());
    
            // Redirect back with error message
            return redirect()->back()->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }   
}
