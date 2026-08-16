<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompetitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:admin');
    }

    public function index()
    {
        $competitions = Competition::latest()->paginate(10);

        return view('admin.competitions.index', compact('competitions'));
    }

    public function create()
    {
        $talents = Talent::active()->get();
        return view('admin.competitions.create', compact('talents'));
    }

    public function createNew()
    {
        $talents = Talent::active()->get();
        return view('admin.competitions.createcompetition', compact('talents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_deadline' => 'required|date|before:end_date',
            'status' => 'required|in:draft,active,closed,cancelled',
            'allowed_talents' => 'required|array|min:1',
            'allowed_talents.*' => 'exists:talents,id',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        try {
            $competition = new Competition();
            $competition->title_ar = $validated['title_ar'];
            $competition->title_en = $validated['title_en'];
            $competition->description_ar = $validated['description_ar'];
            $competition->description_en = $validated['description_en'];
            $competition->start_date = $validated['start_date'];
            $competition->end_date = $validated['end_date'];
            $competition->registration_deadline = $validated['registration_deadline'];
            $competition->status = $validated['status'];
            $competition->max_participants = $validated['max_participants'] ?? null;
            $competition->allowed_talents = $validated['allowed_talents'];
            $competition->created_by = auth()->id();
            $competition->save();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => __('Competition created successfully!'),
                ]);
            }

            return redirect()->route('admin.competitions.index')
                ->with('success', __('Competition created successfully!'));
        } catch (\Exception $e) {
            Log::error('Error creating competition: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('An error occurred while creating the competition.')
                ], 500);
            }

            return redirect()->back()
                ->with('error', __('An error occurred while creating the competition.'))
                ->withInput();
        }
    }

    public function edit(Competition $competition)
    {
        $talents = Talent::active()->get();
        $selectedTalents = $competition->allowed_talents ?? [];
        
        return view('admin.competitions.edit', compact('competition', 'talents', 'selectedTalents'));
    }

    public function update(Request $request, Competition $competition)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_deadline' => 'required|date|before:end_date',
            'status' => 'required|in:draft,active,closed,cancelled',
            'allowed_talents' => 'required|array|min:1',
            'allowed_talents.*' => 'exists:talents,id',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        try {
            $competition->update([
                'title_ar' => $validated['title_ar'],
                'title_en' => $validated['title_en'],
                'description_ar' => $validated['description_ar'],
                'description_en' => $validated['description_en'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'registration_deadline' => $validated['registration_deadline'],
                'status' => $validated['status'],
                'max_participants' => $validated['max_participants'] ?? null,
                'allowed_talents' => $validated['allowed_talents'],
            ]);

            return redirect()->route('admin.competitions.index')
                ->with('success', __('Competition updated successfully!'));
        } catch (\Exception $e) {
            Log::error('Error updating competition: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', __('An error occurred while updating the competition.'))
                ->withInput();
        }
    }

    public function destroy(Competition $competition)
    {
        try {
            $competition->delete();

            return redirect()->route('admin.competitions.index')
                ->with('success', __('Competition deleted successfully!'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('An error occurred while deleting the competition.'));
        }
    }

    public function show(Competition $competition)
    {
        $talents = Talent::active()->get();
        $selectedTalents = $competition->allowed_talents ?? [];
        
        return view('admin.competitions.show', compact('competition', 'talents', 'selectedTalents'));
    }

    public function toggleStatus(Request $request, Competition $competition)
    {
        $competition->update(['status' => $competition->status === 'active' ? 'closed' : 'active']);
        
        return response()->json([
            'success' => true,
            'message' => __('Competition status updated successfully!'),
            'status' => $competition->status
        ]);
    }
}