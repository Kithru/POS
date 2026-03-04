<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function showLogin()
    {
        return view('welcome'); 
    }

   
    public function login(Request $request)
    {
        // Full Validation
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        $credentials = $request->only('email', 'password');

        $remember = $request->has('remember');

        //  Attempt Login
        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();

            // Store required data in session
            session([
                'user_id'    => Auth::user()->id,
                'name'       => Auth::user()->name,
                'user_level' => Auth::user()->user_level,
            ]);

            return redirect()->intended('/dashboard')
                ->with('success', 'Login successful!');
        }
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    // Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}