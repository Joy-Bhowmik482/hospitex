<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(15);
        return view('activity_logs.index', compact('logs'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('activity_logs.show', ['log' => $activityLog]);
    }

    public function loginHistory()
    {
        $logs = ActivityLog::with('user')
            ->where('action', 'like', '%login%')
            ->latest()
            ->paginate(15);

        return view('activity_logs.login_history', compact('logs'));
    }

    public function auditTrail()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(15);
        return view('activity_logs.audit_trail', compact('logs'));
    }
}
