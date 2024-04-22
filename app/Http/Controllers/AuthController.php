<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
public function login(Request $request)
{
    // Validate the form data
    $request->validate([
        'username' => 'required',
        'password' => 'required',

    ]);

    $validatedData = $request->only('username', 'password');
 
    if ($validatedData && Auth::attempt($validatedData))
    {
        $activex = User::where('isactive', 0)->update(['isactive' => 1]);
    
        return redirect()->route('dashboard');
    }
    
}
public function register(Request $request)
{
    // Validate the form data
    $request->validate([
        'fullname' => 'required',
        'username' => 'required',
        'password' => 'required',
        'email' => 'required|email',
    ]);

    $validatedData = $request->only('email', 'password');
 
    User::create([
        'fullname' =>$request->fullname,
        'username' =>$request->username,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);
    return redirect()->route('login')->with('success', 'Register success');
}


}
