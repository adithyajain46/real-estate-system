<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Client;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Property stats by type
        $byType = Property::selectRaw('type, count(*) as count, sum(price) as total_value')
                          ->groupBy('type')
                          ->get();

        // Property stats by status
        $byStatus = Property::selectRaw('status, count(*) as count')
                            ->groupBy('status')
                            ->get();

        // Client stats by type
        $clientByType = Client::selectRaw('type, count(*) as count')
                               ->groupBy('type')
                               ->get();

        // Monthly property additions (last 6 months)
        $monthly = Property::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, count(*) as count')
                           ->whereRaw('created_at >= NOW() - INTERVAL 6 MONTH')
                           ->groupBy('year', 'month')
                           ->orderBy('year')
                           ->orderBy('month')
                           ->get();

        return view('reports.index', compact('byType', 'byStatus', 'clientByType', 'monthly'));
    }
}
