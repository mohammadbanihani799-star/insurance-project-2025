<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InsuranceRequest;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomReportsController extends Controller
{
    /**
     * Display live dashboard with online users, insurances, and requests
     */
    public function dashboard()
    {
        try {
            $insurances = Insurance::orderBy('created_at', 'desc')->get();
            $insuranceRequests = InsuranceRequest::orderBy('created_at', 'desc')->get();

            return view('admin.custom_reports.dashboard', compact('insurances', 'insuranceRequests'));
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحميل لوحة المعلومات: ' . $e->getMessage());
        }
    }

    /**
     * Display custom reports index page with all data
     */
    public function index()
    {
        try {
            $reports = InsuranceRequest::with(['insurance'])
                ->orderBy('created_at', 'desc')
                ->get();

            $statistics = [
                'total_requests' => InsuranceRequest::count(),
                'pending_requests' => InsuranceRequest::where('status', 'pending')->count(),
                'completed_requests' => InsuranceRequest::where('status', 'completed')->count(),
                'total_revenue' => InsuranceRequest::sum('total'),
                'today_requests' => InsuranceRequest::whereDate('created_at', today())->count(),
            ];

            return view('admin.custom_reports.index', compact('reports', 'statistics'));
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحميل التقارير: ' . $e->getMessage());
        }
    }

    /**
     * Display detailed view for a specific report
     */
    public function show($id)
    {
        try {
            $report = InsuranceRequest::with(['insurance'])->findOrFail($id);
            
            return view('admin.custom_reports.show', compact('report'));
        } catch (\Exception $e) {
            return back()->with('error', 'لم يتم العثور على التقرير المطلوب');
        }
    }

    /**
     * Get summary data for AJAX requests
     */
    public function summary()
    {
        try {
            $data = [
                'total_requests' => InsuranceRequest::count(),
                'pending_requests' => InsuranceRequest::where('status', 'pending')->count(),
                'completed_requests' => InsuranceRequest::where('status', 'completed')->count(),
                'total_revenue' => InsuranceRequest::sum('total'),
                'today_requests' => InsuranceRequest::whereDate('created_at', today())->count(),
                'latest_requests' => InsuranceRequest::with(['insurance'])
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get(),
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Export reports to Excel/CSV
     */
    public function export(Request $request)
    {
        return back()->with('info', 'ميزة التصدير قيد التطوير');
    }

    /**
     * Filter reports based on criteria
     */
    public function filter(Request $request)
    {
        try {
            $query = InsuranceRequest::with(['insurance']);

            // تصفية حسب التاريخ
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->input('date_to'));
            }

            // تصفية حسب الحالة
            if ($request->filled('status') && $request->input('status') !== 'all') {
                $query->where('status', $request->input('status'));
            }

            // تصفية حسب نوع التأمين
            if ($request->filled('insurance_id') && $request->input('insurance_id') !== 'all') {
                $query->where('insurance_id', $request->input('insurance_id'));
            }

            $reports = $query->orderBy('created_at', 'desc')->get();

            return view('admin.custom_reports.index', compact('reports'));
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء التصفية: ' . $e->getMessage());
        }
    }
}
