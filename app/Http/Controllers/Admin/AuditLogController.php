<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:admin');
    }

    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        // Apply filters
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        if ($request->has('model_type') && $request->model_type) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $auditLogs = $query->paginate(20);
        $users = \App\Models\User::all();

        return view('admin.audit-logs.index', compact('auditLogs', 'users'));
    }

    public function show(AuditLog $auditLog)
    {
        return view('admin.audit-logs.show', compact('auditLog'));
    }
}