<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Submission;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:manager');
    }

    public function index()
    {
        $submissions = Submission::with(['user', 'competition', 'talent', 'evaluations'])
            ->whereHas('competition', function ($query) {
                $query->where('status', 'active');
            })
            ->whereNotIn('status', ['rejected', 'approved'])
            ->whereDoesntHave('evaluations', function ($query) {
                $query->where('evaluator_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return view('manager.evaluations.index', compact('submissions'));
    }

    public function show(Submission $submission)
    {
        // Check if submission is eligible for evaluation
        if (!$submission->canBeEvaluated()) {
            return redirect()->route('manager.evaluations.index')
                ->with('error', __('This submission cannot be evaluated.'));
        }

        // Check if already evaluated by this manager
        if ($submission->isEvaluatedBy(Auth::id())) {
            return redirect()->route('manager.evaluations.edit', $submission)
                ->with('info', __('You have already evaluated this submission. You can edit your evaluation below.'));
        }

        $submission->load(['user', 'competition', 'talent']);

        return view('manager.evaluations.show', compact('submission'));
    }

    public function create(Submission $submission)
    {
        // Check if submission is eligible for evaluation
        if (!$submission->canBeEvaluated()) {
            return redirect()->route('manager.evaluations.index')
                ->with('error', __('This submission cannot be evaluated.'));
        }

        // Check if already evaluated by this manager
        if ($submission->isEvaluatedBy(Auth::id())) {
            return redirect()->route('manager.evaluations.edit', $submission)
                ->with('info', __('You have already evaluated this submission.'));
        }

        $submission->load(['user', 'competition', 'talent']);

        return view('manager.evaluations.create', compact('submission'));
    }

    public function store(StoreEvaluationRequest $request, Submission $submission)
    {
        // Log the incoming request for debugging
        \Log::info('Evaluation store request received', [
            'submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'request_data' => $request->all(),
            'route_parameters' => request()->route()->parameters()
        ]);

        $this->authorize('evaluate', $submission);

        // Check if already evaluated by this manager
        if ($submission->isEvaluatedBy(Auth::id())) {
            \Log::warning('Submission already evaluated by this manager', [
                'submission_id' => $submission->id,
                'user_id' => Auth::id()
            ]);
            return redirect()->route('manager.evaluations.index')
                ->with('error', __('You have already evaluated this submission.'));
        }

        try {
            DB::beginTransaction();

            // Calculate overall score
            $overallScore = round(($request->creativity_score + $request->technical_score + $request->presentation_score) / 3);
            
            \Log::info('Calculated overall score', [
                'creativity' => $request->creativity_score,
                'technical' => $request->technical_score,
                'presentation' => $request->presentation_score,
                'overall' => $overallScore
            ]);

            // Create the evaluation
            $evaluation = Evaluation::create([
                'submission_id' => $submission->id,
                'evaluator_id' => Auth::id(),
                'creativity_score' => (int) $request->creativity_score,
                'technical_score' => (int) $request->technical_score,
                'presentation_score' => (int) $request->presentation_score,
                'overall_score' => $overallScore,
                'comments' => $request->comments,
                'is_nominated' => $request->is_nominated ?? false,
                'nomination_reason' => ($request->is_nominated ?? false) ? $request->nomination_reason : null,
            ]);

            \Log::info('Evaluation created', ['evaluation_id' => $evaluation->id]);

            // Update submission status based on nomination
            if ($request->is_nominated ?? false) {
                $submission->update(['status' => 'nominated']);
                \Log::info('Submission status updated to nominated', ['submission_id' => $submission->id]);
            } else {
                // Only update to under_review if currently pending
                if ($submission->status === 'pending') {
                    $submission->update(['status' => 'under_review']);
                    \Log::info('Submission status updated to under_review', ['submission_id' => $submission->id]);
                } else {
                    \Log::info('Submission status not updated', [
                        'submission_id' => $submission->id,
                        'current_status' => $submission->status
                    ]);
                }
            }

            DB::commit();

            \Log::info('Evaluation submitted successfully', [
                'evaluation_id' => $evaluation->id,
                'submission_id' => $submission->id,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('manager.evaluations.index')
                ->with('success', __('Evaluation submitted successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error submitting evaluation: ' . $e->getMessage(), [
                'submission_id' => $submission->id,
                'user_id' => Auth::id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', __('An error occurred while submitting the evaluation: ') . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Submission $submission)
    {
        // Check if submission is eligible for evaluation
        if (!$submission->canBeEvaluated()) {
            return redirect()->route('manager.evaluations.index')
                ->with('error', __('This submission cannot be evaluated.'));
        }

        // Check if not yet evaluated by this manager
        if (!$submission->isEvaluatedBy(Auth::id())) {
            return redirect()->route('manager.evaluations.create', $submission)
                ->with('info', __('You have not yet evaluated this submission.'));
        }

        $evaluation = $submission->evaluations()->where('evaluator_id', Auth::id())->first();
        $submission->load(['user', 'competition', 'talent']);

        return view('manager.evaluations.edit', compact('submission', 'evaluation'));
    }

    public function update(UpdateEvaluationRequest $request, Submission $submission)
    {
        // Log the incoming request for debugging
        \Log::info('Evaluation update request received', [
            'submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $this->authorize('evaluate', $submission);

        // Check if not yet evaluated by this manager
        if (!$submission->isEvaluatedBy(Auth::id())) {
            \Log::warning('Submission not yet evaluated by this manager', [
                'submission_id' => $submission->id,
                'user_id' => Auth::id()
            ]);
            return redirect()->route('manager.evaluations.index')
                ->with('error', __('You have not yet evaluated this submission.'));
        }

        try {
            DB::beginTransaction();

            // Get the evaluation
            $evaluation = $submission->evaluations()->where('evaluator_id', Auth::id())->first();

            \Log::info('Found evaluation to update', ['evaluation_id' => $evaluation->id]);

            // Calculate overall score
            $overallScore = round(($request->creativity_score + $request->technical_score + $request->presentation_score) / 3);
            
            \Log::info('Calculated overall score for update', [
                'creativity' => $request->creativity_score,
                'technical' => $request->technical_score,
                'presentation' => $request->presentation_score,
                'overall' => $overallScore
            ]);

            // Update the evaluation
            $evaluation->update([
                'creativity_score' => (int) $request->creativity_score,
                'technical_score' => (int) $request->technical_score,
                'presentation_score' => (int) $request->presentation_score,
                'overall_score' => $overallScore,
                'comments' => $request->comments,
                'is_nominated' => $request->is_nominated ?? false,
                'nomination_reason' => ($request->is_nominated ?? false) ? $request->nomination_reason : null,
            ]);

            \Log::info('Evaluation updated', ['evaluation_id' => $evaluation->id]);

            // Update submission status based on nomination
            if ($request->is_nominated ?? false) {
                // If nominated, update status to nominated regardless of current status
                $submission->update(['status' => 'nominated']);
                \Log::info('Submission status updated to nominated', ['submission_id' => $submission->id]);
            } else {
                // If not nominated and currently pending, change to under_review
                if ($submission->status === 'pending') {
                    $submission->update(['status' => 'under_review']);
                    \Log::info('Submission status updated to under_review (from pending)', ['submission_id' => $submission->id]);
                }
                // If not nominated but already nominated, change back to under_review
                elseif ($submission->status === 'nominated') {
                    $submission->update(['status' => 'under_review']);
                    \Log::info('Submission status updated to under_review (from nominated)', ['submission_id' => $submission->id]);
                } else {
                    \Log::info('Submission status not updated', [
                        'submission_id' => $submission->id,
                        'current_status' => $submission->status
                    ]);
                }
            }

            DB::commit();

            \Log::info('Evaluation updated successfully', [
                'evaluation_id' => $evaluation->id,
                'submission_id' => $submission->id,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('manager.evaluations.index')
                ->with('success', __('Evaluation updated successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating evaluation: ' . $e->getMessage(), [
                'submission_id' => $submission->id,
                'evaluation_id' => $evaluation->id ?? null,
                'user_id' => Auth::id(),
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', __('An error occurred while updating the evaluation: ') . $e->getMessage())
                ->withInput();
        }
    }
}