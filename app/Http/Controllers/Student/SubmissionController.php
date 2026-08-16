<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Submission;
use App\Models\Talent;
use App\Models\SystemNotification;
use App\Services\FileUploadService;
use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->middleware('auth');
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $submissions = Auth::user()->submissions()
            ->with(['competition', 'talent', 'evaluations'])
            ->latest()
            ->paginate(10);

        return view('student.submissions.index', compact('submissions'));
    }

    public function create($competition_id = null)
    {
        $competition = null;
        $competitions = Competition::open()->get();
        
        if ($competition_id) {
            $competition = Competition::findOrFail($competition_id);
            if (!$competition->canAcceptSubmissions()) {
                return redirect()->route('student.submissions.index')
                    ->with('error', __('This competition is not accepting submissions.'));
            }
        }

        $talents = Talent::active()->get();

        return view('student.submissions.create', compact('competitions', 'competition', 'talents'));
    }

    public function store(StoreSubmissionRequest $request)
    {

        $competition = Competition::findOrFail($request->competition_id);
        
        // Check if user already has submission for this competition
        if (Auth::user()->hasSubmissionInCompetition($competition->id)) {
            return redirect()->back()
                ->with('error', __('You already have a submission for this competition.'));
        }

        // Check if competition is still open
        if (!$competition->canAcceptSubmissions()) {
            return redirect()->back()
                ->with('error', __('This competition is not accepting submissions.'));
        }

        // Upload files
        $uploadedFiles = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $this->fileUploadService->upload(
                    $file, 
                    'submissions/' . Auth::id() . '/' . $competition->id
                );
                $uploadedFiles[] = $path;
            }
        }

        // Create submission
        $submission = Submission::create([
            'user_id' => Auth::id(),
            'competition_id' => $request->competition_id,
            'talent_id' => $request->talent_id,
            'title' => $request->title,
            'description' => $request->description,
            'files' => $uploadedFiles,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        // Create notification
        SystemNotification::create([
            'user_id' => Auth::id(),
            'title_ar' => 'تم إرسال مشاركتك بنجاح',
            'title_en' => 'Your submission has been sent successfully',
            'message_ar' => 'تم إرسال مشاركتك في مسابقة "' . $competition->title_ar . '" وهي قيد المراجعة الآن.',
            'message_en' => 'Your submission in competition "' . $competition->title_en . '" has been sent and is now under review.',
            'type' => 'success',
            'data' => ['submission_id' => $submission->id],
        ]);

        return redirect()->route('student.submissions.show', $submission)
            ->with('success', __('Submission created successfully!'));
    }

    public function show(Submission $submission)
    {
        $this->authorize('view', $submission);

        $submission->load(['competition', 'talent', 'evaluations.evaluator']);

        return view('student.submissions.show', compact('submission'));
    }

    public function edit(Submission $submission)
    {
        $this->authorize('update', $submission);

        // Check if submission can be edited
        if (!in_array($submission->status, ['pending', 'under_review'])) {
            return redirect()->route('student.submissions.show', $submission)
                ->with('error', __('This submission cannot be edited.'));
        }

        $competitions = Competition::open()->get();
        $talents = Talent::active()->get();

        return view('student.submissions.edit', compact('submission', 'competitions', 'talents'));
    }

    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        $this->authorize('update', $submission);

        // Handle file uploads
        $currentFiles = $submission->files ?? [];
        
        // Remove selected files
        if ($request->remove_files) {
            foreach ($request->remove_files as $fileToRemove) {
                if (in_array($fileToRemove, $currentFiles)) {
                    Storage::disk('public')->delete($fileToRemove);
                    $currentFiles = array_filter($currentFiles, fn($file) => $file !== $fileToRemove);
                }
            }
        }

        // Add new files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $this->fileUploadService->upload(
                    $file, 
                    'submissions/' . Auth::id() . '/' . $submission->competition_id
                );
                $currentFiles[] = $path;
            }
        }

        // Update submission
        $submission->update([
            'talent_id' => $request->talent_id,
            'title' => $request->title,
            'description' => $request->description,
            'files' => array_values($currentFiles),
        ]);

        return redirect()->route('student.submissions.show', $submission)
            ->with('success', __('Submission updated successfully!'));
    }

    public function destroy(Submission $submission)
    {
        $this->authorize('delete', $submission);

        // Check if submission can be deleted
        if (!in_array($submission->status, ['pending', 'rejected'])) {
            return redirect()->route('student.submissions.index')
                ->with('error', __('This submission cannot be deleted.'));
        }

        // Delete files
        if ($submission->files) {
            foreach ($submission->files as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $submission->delete();

        return redirect()->route('student.submissions.index')
            ->with('success', __('Submission deleted successfully!'));
    }
}