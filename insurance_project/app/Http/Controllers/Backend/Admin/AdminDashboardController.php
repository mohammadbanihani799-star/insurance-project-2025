<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use App\Models\InsuranceRequest;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get counts for dashboard
        $insurances = Insurance::all();
        $insuranceRequests = InsuranceRequest::all();
        
        return view('admin.index', compact('insurances', 'insuranceRequests'));
    }
}
