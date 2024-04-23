<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexa(){

        return view('index');
    }
    public function tables(){

        return view('layout');
    }
}
