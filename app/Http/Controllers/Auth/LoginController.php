<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on role
            return $user->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('user.dashboard');
        }

        // Return with error message
        return redirect()->route('login')->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
