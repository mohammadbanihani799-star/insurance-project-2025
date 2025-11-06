<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorSession;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    // JSON summary for polling on Admin dashboard
    public function summary(Request $request)
    {
        $window = (int) $request->get('window', 120); // seconds

        $active = VisitorSession::active($window)->count();
        $inactive = VisitorSession::inactive($window)->count();

        $recent = VisitorSession::orderByDesc('last_seen_at')
            ->limit(50)
            ->get(['session_id','user_id','ip','current_route','current_url','last_seen_at']);

        return response()->json([
            'active' => $active,
            'inactive' => $inactive,
            'recent' => $recent,
            'window_seconds' => $window,
            'generated_at' => now()->toISOString(),
        ]);
    }
}
