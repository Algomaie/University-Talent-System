<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Excel;
use App\Exports\SubmissionsExport;
use App\Exports\EvaluationsExport;
use App\Exports\ParticipantsExport;
use App\Exports\TalentsExport;

class ReportController extends Controller
{
    public function __construct()
    {
        // Middleware is now handled at the route level
    }

    public function index()
    {
        $reports = Report::latest()->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }

    public function submissions(Request $request)
    {
        try {
            $query = \App\Models\Submission::with(['user', 'competition', 'talent', 'evaluations']);

            // Apply filters if provided
            if ($request->has('competition_id')) {
                $query->where('competition_id', $request->competition_id);
            }
            
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->has('date_from')) {
                $query->where('submitted_at', '>=', $request->date_from);
            }
            
            if ($request->has('date_to')) {
                $query->where('submitted_at', '<=', $request->date_to . ' 23:59:59');
            }

            $submissions = $query->latest()->get();

            return response()->json($submissions);
        } catch (\Exception $e) {
            \Log::error('Submissions report error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load submissions data'], 500);
        }
    }

    public function evaluations(Request $request)
    {
        try {
            $query = \App\Models\Evaluation::with(['submission.user', 'submission.competition', 'evaluator']);

            // Apply filters if provided
            if ($request->has('competition_id')) {
                $query->whereHas('submission', function($q) use ($request) {
                    $q->where('competition_id', $request->competition_id);
                });
            }
            
            if ($request->has('evaluator_id')) {
                $query->where('evaluator_id', $request->evaluator_id);
            }
            
            if ($request->has('date_from')) {
                $query->where('created_at', '>=', $request->date_from);
            }
            
            if ($request->has('date_to')) {
                $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
            }

            $evaluations = $query->latest()->get();

            return response()->json($evaluations);
        } catch (\Exception $e) {
            \Log::error('Evaluations report error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load evaluations data'], 500);
        }
    }

    public function participants(Request $request)
    {
        try {
            $query = \App\Models\User::students();

            // Apply filters if provided
            if ($request->has('competition_id')) {
                $query->whereHas('submissions', function($q) use ($request) {
                    $q->where('competition_id', $request->competition_id);
                });
            }
            
            if ($request->has('talent_id')) {
                $query->whereHas('submissions', function($q) use ($request) {
                    $q->where('talent_id', $request->talent_id);
                });
            }

            $participants = $query->withCount('submissions')->latest()->get();

            return response()->json($participants);
        } catch (\Exception $e) {
            \Log::error('Participants report error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load participants data'], 500);
        }
    }

    public function talents(Request $request)
    {
        try {
            $query = \App\Models\Talent::with('submissions');

            // Apply filters if provided
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            $talents = $query->withCount('submissions')->latest()->get();

            return response()->json($talents);
        } catch (\Exception $e) {
            \Log::error('Talents report error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load talents data'], 500);
        }
    }

    public function generate(Request $request)
    {
        try {
            // Handle both JSON and form data
            $requestData = $request->all();
            
            // If it's JSON data, get the content
            if ($request->isJson()) {
                $requestData = $request->json()->all();
            }

            // Validate the data
            $validatedData = validator($requestData, [
                'type' => 'required|in:submissions,evaluations,participants,talents',
                'format' => 'required|in:pdf,excel',
                'filters' => 'array'
            ])->validate();

            DB::beginTransaction();

            // Generate report data based on type and filters
            $data = [];
            $reportType = $validatedData['type'];
            
            switch ($reportType) {
                case 'submissions':
                    $data = $this->getSubmissionsData($validatedData['filters'] ?? []);
                    break;
                case 'evaluations':
                    $data = $this->getEvaluationsData($validatedData['filters'] ?? []);
                    break;
                case 'participants':
                    $data = $this->getParticipantsData($validatedData['filters'] ?? []);
                    break;
                case 'talents':
                    $data = $this->getTalentsData($validatedData['filters'] ?? []);
                    break;
            }

            // Generate file
            $fileName = $reportType . '_' . now()->format('Y-m-d_H-i-s') . '.' . $validatedData['format'];
            $filePath = 'reports/' . $fileName;
            
            if ($validatedData['format'] === 'pdf') {
                $pdf = PDF::loadView('admin.reports.pdf.' . $reportType, ['data' => $data]);
                $pdf->save(storage_path('app/public/' . $filePath));
            } else {
                // Excel export
                $exportClass = '\App\Exports\\' . ucfirst($reportType) . 'Export';
                $export = new $exportClass($data);
                // Store in public disk
                \Maatwebsite\Excel\Facades\Excel::store($export, $filePath, 'public');
            }

            // Create report record
            $report = Report::create([
                'title' => __(':type Report (:format)', [
                    'type' => ucfirst($reportType), 
                    'format' => strtoupper($validatedData['format'])
                ]),
                'type' => $reportType,
                'data' => [
                    'filters' => $validatedData['filters'] ?? [],
                    'generated_at' => now()->toDateTimeString(),
                    'generated_by' => auth()->id()
                ],
                'file_path' => $filePath
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('Report generated successfully!'),
                'report' => $report
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Report generation error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            
            // Return JSON error response instead of HTML error page
            return response()->json([
                'success' => false,
                'message' => __('An error occurred while generating the report: ') . $e->getMessage()
            ], 500);
        }
    }

    public function download(Report $report)
    {
        try {
            $path = storage_path('app/public/' . $report->file_path);
            
            if (!file_exists($path)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            return response()->download($path);
        } catch (\Exception $e) {
            \Log::error('Report download error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to download report'], 500);
        }
    }

    private function getSubmissionsData($filters = [])
    {
        $query = \App\Models\Submission::with(['user', 'competition', 'talent', 'evaluations']);

        // Apply filters
        if (isset($filters['competition_id'])) {
            $query->where('competition_id', $filters['competition_id']);
        }
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['date_from'])) {
            $query->where('submitted_at', '>=', $filters['date_from']);
        }
        
        if (isset($filters['date_to'])) {
            $query->where('submitted_at', '<=', $filters['date_to'] . ' 23:59:59');
        }

        return $query->latest()->get();
    }

    private function getEvaluationsData($filters = [])
    {
        $query = \App\Models\Evaluation::with(['submission.user', 'submission.competition', 'evaluator']);

        // Apply filters
        if (isset($filters['competition_id'])) {
            $query->whereHas('submission', function($q) use ($filters) {
                $q->where('competition_id', $filters['competition_id']);
            });
        }
        
        if (isset($filters['evaluator_id'])) {
            $query->where('evaluator_id', $filters['evaluator_id']);
        }
        
        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }
        
        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to'] . ' 23:59:59');
        }

        return $query->latest()->get();
    }

    private function getParticipantsData($filters = [])
    {
        $query = \App\Models\User::students();

        // Apply filters
        if (isset($filters['competition_id'])) {
            $query->whereHas('submissions', function($q) use ($filters) {
                $q->where('competition_id', $filters['competition_id']);
            });
        }
        
        if (isset($filters['talent_id'])) {
            $query->whereHas('submissions', function($q) use ($filters) {
                $q->where('talent_id', $filters['talent_id']);
            });
        }

        return $query->withCount('submissions')->latest()->get();
    }

    private function getTalentsData($filters = [])
    {
        $query = \App\Models\Talent::with('submissions');

        // Apply filters
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->withCount('submissions')->latest()->get();
    }
}