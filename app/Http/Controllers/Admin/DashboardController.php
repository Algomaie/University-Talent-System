<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Middleware is now handled at the route level
    }

    public function index()
    {
        $stats = [
            'total_students' => User::students()->count(),
            'total_managers' => User::managers()->count(),
            'total_competitions' => Competition::count(),
            'total_submissions' => Submission::count(),
            'pending_submissions' => Submission::where('status', 'pending')->count(),
            'nominated_submissions' => Submission::where('status', 'nominated')->count(),
            'approved_submissions' => Submission::where('status', 'approved')->count(),
            'rejected_submissions' => Submission::where('status', 'rejected')->count(),
        ];

        $recentSubmissions = Submission::with(['user', 'competition', 'talent'])
            ->latest()
            ->limit(5)
            ->get();

        $activeCompetitions = Competition::active()->withCount('submissions')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentSubmissions', 'activeCompetitions'));
    }
    
    public function nominatedSubmissions()
    {
        $submissions = Submission::with(['user', 'competition', 'talent', 'evaluations'])
            ->where('status', 'nominated')
            ->latest()
            ->paginate(10);

        return view('admin.nominated.index', compact('submissions'));
    }
    
    public function approveNomination(Submission $submission)
    {
        // Check if submission is actually nominated
        if ($submission->status !== 'nominated') {
            return redirect()->route('admin.nominated.index')
                ->with('error', __('This submission is not nominated.'));
        }
        
        // Update submission status to approved
        $submission->update(['status' => 'approved']);
        
        return redirect()->route('admin.nominated.index')
            ->with('success', __('Submission approved successfully!'));
    }
    
    public function rejectNomination(Submission $submission)
    {
        // Check if submission is actually nominated
        if ($submission->status !== 'nominated') {
            return redirect()->route('admin.nominated.index')
                ->with('error', __('This submission is not nominated.'));
        }
        
        // Update submission status to rejected
        $submission->update(['status' => 'rejected']);
        
        return redirect()->route('admin.nominated.index')
            ->with('success', __('Submission rejected successfully!'));
    }
}