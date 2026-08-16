<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Submission;
use App\Models\Evaluation;
use App\Models\User;
use App\Http\Requests\StoreCompetitionRequest;
use App\Http\Requests\UpdateCompetitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompetitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:manager');
    }

    /**
     * Display a listing of competitions managed by the current manager
     */
    public function index()
    {
        // Get competitions where the current user is assigned as a manager
        $competitions = Competition::where('created_by', Auth::id())
            ->orWhereHas('managers', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->withCount('submissions')
            ->latest()
            ->paginate(10);

        return view('manager.competitions.index', compact('competitions'));
    }

    /**
     * Show the form for creating a new competition
     */
    public function create()
    {
        $talents = \App\Models\Talent::active()->get();
        return view('manager.competitions.create', compact('talents'));
    }

    /**
     * Store a newly created competition in storage
     */
    public function store(StoreCompetitionRequest $request)
    {

        try {
            DB::beginTransaction();

            $competition = Competition::create([
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'registration_deadline' => $request->registration_deadline,
                'status' => $request->status,
                'max_participants' => $request->max_participants,
                'allowed_talents' => $request->allowed_talents,
                'created_by' => Auth::id(),
                'evaluation_criteria' => $request->evaluation_criteria,
            ]);

            // Assign current user as manager
            $competition->managers()->attach(Auth::id());

            DB::commit();

            return redirect()->route('manager.competitions.index')
                ->with('success', __('Competition created successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', __('Failed to create competition: ') . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified competition
     */
    public function show(Competition $competition)
    {
        $this->authorize('view', $competition);

        $competition->load(['submissions.user', 'submissions.talent']);
        
        // Get statistics
        $stats = [
            'total_submissions' => $competition->submissions()->count(),
            'pending_evaluations' => $competition->submissions()->whereDoesntHave('evaluations', function ($query) {
                $query->where('evaluator_id', Auth::id());
            })->count(),
            'evaluated_submissions' => $competition->submissions()->whereHas('evaluations', function ($query) {
                $query->where('evaluator_id', Auth::id());
            })->count(),
            'nominated_submissions' => $competition->submissions()->where('status', 'nominated')->count(),
        ];

        return view('manager.competitions.show', compact('competition', 'stats'));
    }

    /**
     * Show the form for editing the specified competition
     */
    public function edit(Competition $competition)
    {
        $this->authorize('update', $competition);

        $talents = \App\Models\Talent::active()->get();
        $selectedTalents = $competition->allowedTalentsList()->pluck('id')->toArray();

        return view('manager.competitions.edit', compact('competition', 'talents', 'selectedTalents'));
    }

    /**
     * Update the specified competition in storage
     */
    public function update(UpdateCompetitionRequest $request, Competition $competition)
    {
        $this->authorize('update', $competition);

        try {
            $competition->update([
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'registration_deadline' => $request->registration_deadline,
                'status' => $request->status,
                'max_participants' => $request->max_participants,
                'allowed_talents' => $request->allowed_talents,
                'evaluation_criteria' => $request->evaluation_criteria,
            ]);

            return redirect()->route('manager.competitions.show', $competition)
                ->with('success', __('Competition updated successfully!'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('Failed to update competition: ') . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Archive the specified competition
     */
    public function archive(Competition $competition)
    {
        $this->authorize('update', $competition);

        try {
            $competition->update(['status' => 'closed']);
            
            return redirect()->route('manager.competitions.index')
                ->with('success', __('Competition archived successfully!'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('Failed to archive competition: ') . $e->getMessage());
        }
    }

    /**
     * Display submissions for a specific competition
     */
    public function submissions(Competition $competition)
    {
        $this->authorize('manage', $competition);

        $submissions = $competition->submissions()
            ->with(['user', 'talent', 'evaluations' => function ($query) {
                $query->where('evaluator_id', Auth::id());
            }])
            ->latest()
            ->paginate(15);

        return view('manager.competitions.submissions', compact('competition', 'submissions'));
    }

    /**
     * Generate ranking list for a competition
     */
    public function rankings(Competition $competition)
    {
        $this->authorize('view', $competition);

        // Get submissions with average scores
        $rankings = $competition->submissions()
            ->with(['user', 'talent'])
            ->whereHas('evaluations')
            ->addSelect([
                'avg_creativity' => \App\Models\Evaluation::selectRaw('AVG(creativity_score)')
                    ->whereColumn('submission_id', 'submissions.id'),
                'avg_technical' => \App\Models\Evaluation::selectRaw('AVG(technical_score)')
                    ->whereColumn('submission_id', 'submissions.id'),
                'avg_presentation' => \App\Models\Evaluation::selectRaw('AVG(presentation_score)')
                    ->whereColumn('submission_id', 'submissions.id'),
                'avg_overall' => \App\Models\Evaluation::selectRaw('AVG(overall_score)')
                    ->whereColumn('submission_id', 'submissions.id'),
            ])
            ->orderBy('avg_overall', 'desc')
            ->paginate(20);

        return view('manager.competitions.rankings', compact('competition', 'rankings'));
    }

    /**
     * Send bulk notifications to competition participants
     */
    public function sendNotifications(Request $request, Competition $competition)
    {
        $this->authorize('manage', $competition);

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Get all participants (users who submitted to this competition)
            $participants = User::whereIn('id', function ($query) use ($competition) {
                $query->select('user_id')
                    ->from('submissions')
                    ->where('competition_id', $competition->id);
            })->get();

            // Use NotificationService to send notifications
            $notificationService = new \App\Services\NotificationService();
            
            foreach ($participants as $participant) {
                $notificationService->sendNotification(
                    $participant,
                    $request->subject,
                    $request->subject,
                    $request->message,
                    $request->message,
                    'info',
                    [
                        'competition_id' => $competition->id,
                        'competition_title' => $competition->title,
                        'subject' => $request->subject,
                        'message' => $request->message,
                    ]
                );
            }

            return redirect()->back()
                ->with('success', __('Notifications sent to :count participants.', ['count' => $participants->count()]));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('Failed to send notifications: ') . $e->getMessage());
        }
    }

    /**
     * Check if the current user can manage this competition
     */
    private function canManageCompetition(Competition $competition)
    {
        return $competition->created_by == Auth::id() || 
               $competition->managers()->where('user_id', Auth::id())->exists();
    }
}