<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;



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
    try {
        // Validate the form data
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $validatedData = $request->only('username', 'password');

        if ($validatedData && Auth::attempt($validatedData)) {
            $user = Auth::user();
            

            // Update user activity status
            $user->update(['isactive' => 1]);

            return redirect()->route('dashboard');
        } else {
            throw new \Exception('Invalid credentials. Please try again.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', $e->getMessage());
    }
}

public function register(Request $request)
{
    $request->validate([
        'fullname' => 'required',
        'username' => 'required',
        'password' => 'required',
        'email' => 'required|email',
    ]);
    try {
        User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
        ]);
        return redirect()->route('login')->with('success', 'Registration successful');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Registration failed: ' . $e->getMessage());
    }
}

function logoutx(){
    $activex = User::where('isactive', 1)->update(['isactive' => 0]);
    Session::flush();
    Auth::logout();
    return redirect('/');
 }
}
