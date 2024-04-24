<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\TasFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;



class DashboardController extends Controller
{
    public function indexa()
    {
        return view('index');
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
        return view('tas.view', compact('tasFiles'));
    }

    public function saveRemarks(Request $request)
    {
        $request->validate([
            'remarks' => 'required|string|max:255',
            'tas_file_id' => 'required|exists:tas_files,id', 
        ]);

        try {
            $id = $request->input('tas_file_id');
            $tasFile = TasFile::findOrFail($id);
            $tasFile->REMARKS = $request->input('remarks');
            $tasFile->save();
            return back()->with('success', 'Remarks saved successfully!');
        } catch (\Throwable $th) {
            logger()->error('Error saving remarks: ' . $th->getMessage());
            return back()->with('error', 'Failed to save remarks. Please try again later.');
        }
    }

    public function submitForm(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'case_no' => 'required|string',
                'top' => 'required|string',
                'name' => 'required|string',
                'violation' => 'required|string',
                'transaction_no' => 'required|string',
                'transaction_date' => 'required|date',
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
                    'violation' => $validatedData['violation'],
                    'transaction_no' => $validatedData['transaction_no'],
                    'transaction_date' => $validatedData['transaction_date'],
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
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
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
