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
    $tasFiles = TasFile::paginate(10); 
    return view('tas.manage', compact('tasFiles'));
}

    
    
}
