<?php

namespace App\Http\Controllers;
use App\Models\TasFile;
use Illuminate\Http\Request;

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
public function saveRemarks(Request $request)
{
    $request->validate([
        'remarks' => 'required|string|max:255',
    ]);

    try {
        // Retrieve the TasFile ID from the request
        $id = $request->input('tas_file_id');

        // Retrieve the TasFile object
        $tasFile = TasFile::findOrFail($id);
        
        // Update the REMARKS attribute with the input value
        $tasFile->REMARKS = $request->input('remarks');

        // Save the TasFile object
        $tasFile->save();

        // Redirect back with a success message
        return back()->with('success', 'Remarks saved successfully!');
    } catch (\Throwable $th) {
        // Log the error
        logger()->error('Error saving remarks: ' . $th->getMessage());

        // Redirect back with an error message
        return back()->with('error', 'Failed to save remarks. Please try again later.');
    }
}



    
}
