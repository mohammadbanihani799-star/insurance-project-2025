<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserDevice;
use App\Models\InsuranceVisit;
use App\Models\AdminLoginEvent;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Show monitoring dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get initial data
        $activeDevices = UserDevice::active(5)
            ->orderBy('last_seen_at', 'desc')
            ->limit(50)
            ->get();

        $recentVisits = InsuranceVisit::recent(60)
            ->orderBy('visited_at', 'desc')
            ->limit(200)
            ->get();

        $recentLoginEvents = AdminLoginEvent::recent(24)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('admin.monitoring.index', compact(
            'activeDevices',
            'recentVisits',
            'recentLoginEvents'
        ));
    }

    /**
     * AJAX endpoint for polling updates
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function poll(Request $request)
    {
        try {
            // Get active devices (last 5 minutes)
            $activeDevices = UserDevice::active(5)
                ->orderBy('last_seen_at', 'desc')
                ->limit(50)
                ->get()
                ->map(function ($device) {
                    return [
                        'id' => $device->id,
                        'device_id' => substr($device->device_id, 0, 8) . '...',
                        'ip' => $device->ip,
                        'platform' => $device->platform,
                        'browser' => $device->browser,
                        'last_seen' => $device->last_seen_at->diffForHumans(),
                        'last_seen_raw' => $device->last_seen_at->toIso8601String(),
                        'owner' => $device->owner ? $device->owner->name ?? 'Unknown' : 'Guest'
                    ];
                });

            // Get recent visits (last hour)
            $recentVisits = InsuranceVisit::recent(60)
                ->orderBy('visited_at', 'desc')
                ->limit(200)
                ->get()
                ->map(function ($visit) {
                    return [
                        'id' => $visit->id,
                        'device_id' => substr($visit->device_id, 0, 8) . '...',
                        'path' => $visit->path,
                        'step_key' => $visit->step_key,
                        'visited_at' => $visit->visited_at->diffForHumans(),
                        'visited_at_raw' => $visit->visited_at->toIso8601String()
                    ];
                });

            // Get recent login events (last 24 hours)
            $recentLoginEvents = AdminLoginEvent::recent(24)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'event' => $event->event,
                        'ip' => $event->ip,
                        'device_id' => substr($event->device_id ?? '', 0, 8) . '...',
                        'note' => $event->note,
                        'created_at' => $event->created_at->diffForHumans(),
                        'created_at_raw' => $event->created_at->toIso8601String(),
                        'admin' => $event->admin ? $event->admin->name : 'Unknown'
                    ];
                });

            return response()->json([
                'success' => true,
                'active_devices_count' => $activeDevices->count(),
                'active_devices' => $activeDevices,
                'recent_visits_count' => $recentVisits->count(),
                'recent_visits' => $recentVisits,
                'recent_login_events_count' => $recentLoginEvents->count(),
                'recent_login_events' => $recentLoginEvents,
                'timestamp' => now()->toIso8601String()
            ]);

        } catch (\Exception $e) {
            \Log::error('Monitoring poll error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Server error'
            ], 500);
        }
    }
}
