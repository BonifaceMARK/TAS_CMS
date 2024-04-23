<?php

namespace App\Http\Controllers;
use App\Models\TasFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class DashboardController extends Controller
{
    public function indexa(){

        return view('index');
    }
    public function tables(){

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
    public function submitForm(Request $request)
    {
        

        try {
            // Validate the form data
            $validatedData = $request->validate([
                'case_no' => 'required|string',
                'top' => 'required|string',
                'name' => 'required|string',
                'violation' => 'required|string',
                'transaction_no' => 'required|string',
                'transaction_date' => 'required|date',
                'file_attachment' => 'nullable|array', // Ensure it's an array
                'file_attachment.*' => 'nullable|file|max:5120', // Validate each file
            ]);
        
            // Start transaction
            DB::beginTransaction();
            if ($request->hasFile('file_attachment')) {
                $filePaths = []; // Array to store file names
                foreach ($request->file('file_attachment') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('attachments', $fileName); // Store the file
                    $filePaths[] = $fileName; // Store the file name in the array
                }
                // Store file names in JSON format in the database
                $tasFile->file_attach = json_encode($filePaths);
            }
            // Create a new TasFile instance
            $tasFile = new TasFile([
                'case_no' => $validatedData['case_no'],
                'top' =>$validatedData['top'],
                'name' => $validatedData['name'],
                'violation' => $validatedData['violation'],
                'transaction_no' => $validatedData['transaction_no'],
                'transaction_date' => $validatedData['transaction_date'],
            ]);
        
            // Handle file attachments if present
           
        
            // Save the TasFile instance
            $tasFile->save();
        
            // Commit transaction
            DB::commit();
        
            // Redirect or return a response
            return redirect()->back()->with('success', 'Form submitted successfully!');
        } catch (ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            // Log or handle the error
            return redirect()->back()->with('error', 'An error occurred while processing the form.');
        }
    }
    
    
}
