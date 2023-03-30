<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\CarPark;
use App\Models\Feedback;
use App\Models\Packages;
use App\Models\ParkingRecords;
use App\Models\Reservations;
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
        $ridesAvailability = [0, 0];
        $ridesReservations = [];

        foreach (Bike::where('status', 1)->get() as $key => $value) {
            if ($value->available == 1) {
                $ridesAvailability[0]++;
            } else {
                $ridesAvailability[1]++;
            }
        }

        foreach (Reservations::where('status', 2)->where('is_paid', 1)->get() as $key => $value) {

            $date=Carbon::parse($value->ride_at)->format('Y-m-d');

            if (array_key_exists($date, $ridesReservations)) {
                $ridesReservations[$date] = $ridesReservations[$date] + (float)$value->total;
            } else {
                $ridesReservations[$date] = (float)$value->total;
            }
        }

        $ridesReservationsDates = array_keys($ridesReservations);
        $ridesReservations = array_values($ridesReservations);

        return view('home', compact('ridesAvailability', 'ridesReservationsDates', 'ridesReservations'));
    }
}
