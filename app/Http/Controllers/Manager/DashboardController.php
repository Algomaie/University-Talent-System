<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Submission;
use App\Models\Evaluation;
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
            'total_submissions' => Submission::count(),
            'pending_evaluations' => Submission::whereDoesntHave('evaluations', function ($query) {
                $query->where('evaluator_id', Auth::id());
            })->count(),
            'my_evaluations' => Evaluation::where('evaluator_id', Auth::id())->count(),
            'nominated_submissions' => Evaluation::where('evaluator_id', Auth::id())
                ->where('is_nominated', true)->count(),
        ];

        $recent_submissions = Submission::with(['user', 'competition', 'talent'])
            ->latest()
            ->take(5)
            ->get();

        $pending_evaluations = Submission::with(['user', 'competition', 'talent'])
            ->whereDoesntHave('evaluations', function ($query) {
                $query->where('evaluator_id', Auth::id());
            })
            ->latest()
            ->take(10)
            ->get();

        return view('manager.dashboard', compact('stats', 'recent_submissions', 'pending_evaluations'));
    }
}