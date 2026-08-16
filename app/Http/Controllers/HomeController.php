<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
class HomeController extends Controller
{
    public function index()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'manager') {
                return redirect()->route('manager.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
        }
        
        // For guests, show the home page with competitions and stats
        $competitions = \App\Models\Competition::active()->limit(6)->get();
        $stats = [
            'total_students' => \App\Models\User::students()->count(),
            'total_competitions' => \App\Models\Competition::count(),
            'total_submissions' => \App\Models\Submission::count(),
            'total_talents' => \App\Models\Talent::active()->count(),
        ];

        return view('home.index', compact('competitions', 'stats'));
    }

    public function about()
    {
        return view('home.about');
    }

    public function switchLanguage($locale)
    {
        if (in_array($locale, ['ar', 'en'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        return redirect()->back();
    }
}