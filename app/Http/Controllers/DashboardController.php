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
    $tasFiles = TasFile::paginate(10); 
    return view('tas.manage', compact('tasFiles'));
}

    
    
}
