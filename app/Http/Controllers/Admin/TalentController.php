<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller;
use App\Models\Talent;
use App\Http\Requests\StoreTalentRequest;
use App\Http\Requests\UpdateTalentRequest;
use Illuminate\Http\Request;

class TalentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:admin');
    }

    public function index()
    {
        $talents = Talent::latest()->paginate(10);

        return view('admin.talents.index', compact('talents'));
    }

    public function create()
    {
        return view('admin.talents.create');
    }

    public function store(StoreTalentRequest $request)
    {
        try {
            Talent::create($request->validated());

            return redirect()->route('admin.talents.index')
                ->with('success', __('Talent created successfully!'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('An error occurred while creating the talent.'));
        }
    }

    public function edit(Talent $talent)
    {
        return view('admin.talents.edit', compact('talent'));
    }

    public function update(UpdateTalentRequest $request, Talent $talent)
    {
        try {
            $talent->update($request->validated());

            return redirect()->route('admin.talents.index')
                ->with('success', __('Talent updated successfully!'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('An error occurred while updating the talent.'));
        }
    }

    public function destroy(Talent $talent)
    {
        try {
            $talent->delete();

            return redirect()->route('admin.talents.index')
                ->with('success', __('Talent deleted successfully!'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('An error occurred while deleting the talent.'));
        }
    }

    public function toggleStatus(Request $request, Talent $talent)
    {
        $talent->update(['status' => $talent->status === 'active' ? 'inactive' : 'active']);
        
        return response()->json([
            'success' => true,
            'message' => __('Talent status updated successfully!'),
            'status' => $talent->status
        ]);
    }
}