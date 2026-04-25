<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===============================
    // Show Register Form
    // ===============================
    public function showRegister()
    {
        return view('register');
    }

    // ===============================
    // Register User (Student & Company Only)
    // ===============================
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:student,company'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect('/login')->with('success', 'Registration Successful. Please Login.');
    }

    // ===============================
    // Show Login Form
    // ===============================
    public function showLogin()
    {
        return view('login');
    }

    // ===============================
    // Login User (Student, Company, Admin)
    // ===============================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // STUDENT
            if ($user->role == 'student') {
                return redirect('/student/dashboard');
            }

            // COMPANY
            if ($user->role == 'company') {
                return redirect('/company/dashboard');
            }

            // ADMIN
            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            }
        }

        return back()->with('error', 'Invalid Email or Password');
    }

    // ===============================
    // Logout
    // ===============================
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}