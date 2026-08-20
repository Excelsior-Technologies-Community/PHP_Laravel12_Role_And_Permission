<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs.
     */
    public function index(): View
    {
        $logs = ActivityLog::with('user')
            ->orderBy('id', 'asc')
            ->paginate(5);

        return view('activity_logs.index', compact('logs'));
    }

    /**
     * Display a single activity log.
     */
    public function show(ActivityLog $activityLog): View
    {
        $activityLog->load('user');

        return view('activity_logs.show', compact('activityLog'));
    }

    /**
     * Delete a single activity log.
     */
    public function destroy(ActivityLog $activityLog): RedirectResponse
    {
        $activityLog->delete();

        return redirect()
            ->route('activity-logs.index')
            ->with('success', 'Activity log deleted successfully.');
    }

    /**
     * Delete all activity logs.
     */
    public function clear(): RedirectResponse
    {
        ActivityLog::query()->delete();

        return redirect()
            ->route('activity-logs.index')
            ->with('success', 'All activity logs cleared successfully.');
    }
}
