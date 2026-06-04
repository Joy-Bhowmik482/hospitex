<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('route')) {
            $query->where('route', 'like', '%' . $request->route . '%');
        }

        $logs = $query->latest()->paginate(15)->withQueryString();

        $users = \App\Models\User::whereHas('activityLogs')->select('id', 'name')->get();
        $actions = ActivityLog::distinct()->pluck('action');

        return view('activity_logs.index', compact('logs', 'users', 'actions'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('activity_logs.show', ['log' => $activityLog]);
    }

    public function loginHistory(Request $request)
    {
        $query = ActivityLog::with('user')
            ->whereIn('action', ['login', 'logout']);

        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs = $query->latest()->paginate(15)->withQueryString();

        $users = \App\Models\User::whereHas('activityLogs', function($q) {
            $q->whereIn('action', ['login', 'logout']);
        })->select('id', 'name')->get();

        return view('activity_logs.login_history', compact('logs', 'users'));
    }

    public function auditTrail(Request $request)
    {
        $query = ActivityLog::with('user')
            ->whereNotIn('action', ['login', 'logout']);

        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('route')) {
            $query->where('route', 'like', '%' . $request->route . '%');
        }

        $logs = $query->latest()->paginate(15)->withQueryString();

        $users = \App\Models\User::whereHas('activityLogs', function($q) {
            $q->whereNotIn('action', ['login', 'logout']);
        })->select('id', 'name')->get();

        $actions = ActivityLog::whereNotIn('action', ['login', 'logout'])->distinct()->pluck('action');

        return view('activity_logs.audit_trail', compact('logs', 'users', 'actions'));
    }
}
