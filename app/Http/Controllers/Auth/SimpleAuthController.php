<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SimpleAuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account is not active. Please contact administration.');
            }

            // Redirect based on role
            $route = match ($user->role) {
                'student' => 'student.dashboard',
                'manager' => 'manager.dashboard',
                default => 'admin.dashboard',
            };

            return redirect()->intended(route($route, absolute: false))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:student,manager,admin'],
            'student_id' => ['required', 'string', 'max:20'],
            'terms' => ['accepted'],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'student_id' => $request->student_id,
                'is_active' => true,
            ]);

            // Log the user in
            Auth::login($user);

            // Redirect based on role
            $route = match ($user->role) {
                'student' => 'student.dashboard',
                'manager' => 'manager.dashboard',
                default => 'admin.dashboard',
            };

            return redirect(route($route, absolute: false))
                ->with('success', 'Account created successfully! Welcome to the Student Talents System.');

        } catch (\Exception $e) {
            return back()->withInput($request->only('name', 'email', 'student_id', 'role'))
                ->with('error', 'Failed to create account. Please try again.');
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}