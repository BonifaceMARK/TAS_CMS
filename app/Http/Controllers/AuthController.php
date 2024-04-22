<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loadlogin()
{
    return view('login');
}

public function loadregister()
{
    return view('register');
}
}
