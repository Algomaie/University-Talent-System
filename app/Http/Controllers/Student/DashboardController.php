<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Submission;
use App\Models\SystemNotification;
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
        $user = Auth::user();
        
        $stats = [
            'total_submissions' => $user->submissions()->count(),
            'pending_submissions' => $user->submissions()->pending()->count(),
            'approved_submissions' => $user->submissions()->approved()->count(),
            'unread_notifications' => $user->notifications()->unread()->count(),
        ];

        $recent_submissions = $user->submissions()
            ->with(['competition', 'talent'])
            ->latest()
            ->take(5)
            ->get();

        $open_competitions = Competition::open()
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->take(3)
            ->get();

        $recent_notifications = $user->notifications()
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'stats', 
            'recent_submissions', 
            'open_competitions', 
            'recent_notifications'
        ));
    }
    
    public function notifications()
    {
        $notifications = Auth::user()->notifications()
            ->latest()
            ->paginate(15);

        return view('student.notifications.index', compact('notifications'));
    }
    
    public function markNotificationAsRead(SystemNotification $notification)
    {
        // Check if user owns this notification
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }
    
    public function markAllNotificationsAsRead(Request $request)
    {
        // Handle both GET and POST requests for backward compatibility
        if ($request->isMethod('get')) {
            // Redirect to dashboard with success message
            return redirect()->route('student.dashboard')
                ->with('success', __('All notifications have been deleted.'));
        }
        
        // Delete all notifications for the user
        Auth::user()->notifications()->delete();
        
        // If it's an AJAX request, return JSON response
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        // Otherwise redirect back with success message
        return redirect()->back()
            ->with('success', __('All notifications have been deleted.'));
    }
}