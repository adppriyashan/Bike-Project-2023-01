<?php

namespace App\Http\Controllers;

use App\Models\CarPark;
use App\Models\Feedback;
use App\Models\Packages;
use App\Models\ParkingRecords;
use App\Models\Tier;
use App\Models\Transport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transports = 0;
        $packages = 0;
        $users = 0;
        $feedbacks = 0;

        return view('home', compact('transports', 'packages', 'users', 'feedbacks'));
    }
}
