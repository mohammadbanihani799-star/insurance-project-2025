<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\InsuranceVisit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Record a visit ping
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ping(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'path' => 'required|string|max:500',
                'step' => 'nullable|string|max:100',
                'meta' => 'nullable|array'
            ]);

            // Get device ID from request attributes (set by TrackDevice middleware)
            // Use session or generate if not exists
            $deviceId = session('device_id') ?? $request->header('X-Device-ID') ?? session()->getId();
            
            if (!$deviceId) {
                return response()->json(['ok' => false, 'error' => 'Device ID missing'], 400);
            }

            // Create visit record
            InsuranceVisit::create([
                'device_id' => $deviceId,
                'session_id' => session()->getId(),
                'path' => $validated['path'],
                'step_key' => $validated['step'] ?? null,
                'meta' => $validated['meta'] ?? null,
                'visited_at' => now()
            ]);

            return response()->json(['ok' => true]);
            
        } catch (\Exception $e) {
            \Log::error('Visit ping error: ' . $e->getMessage());
            return response()->json(['ok' => false, 'error' => 'Server error'], 500);
        }
    }
}
