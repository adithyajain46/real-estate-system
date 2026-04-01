<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalProperties  = Property::count();
        $availableProps   = Property::where('status', 'available')->count();
        $soldProps        = Property::where('status', 'sold')->count();
        $rentedProps      = Property::where('status', 'rented')->count();
        $totalClients     = Client::count();
        $buyers           = Client::where('type', 'buyer')->count();
        $sellers          = Client::where('type', 'seller')->count();
        $totalValue       = Property::where('status', 'available')->sum('price');
        $recentProperties = Property::latest()->take(5)->get();
        $recentClients    = Client::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalProperties', 'availableProps', 'soldProps', 'rentedProps',
            'totalClients', 'buyers', 'sellers', 'totalValue',
            'recentProperties', 'recentClients'
        ));
    }
}
