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

    // Retrieve the TasFile object
    $tasFile = TasFile::find($id);


    if ($tasFile) {

        $tasFile->REMARKS = $request->input('remarks');

        $tasFile->save();

        return back()->with('success', 'Remarks saved successfully!');
    } else {

        return back()->with('error', 'Failed to save remarks. File not found.');
    }
}

    
}
