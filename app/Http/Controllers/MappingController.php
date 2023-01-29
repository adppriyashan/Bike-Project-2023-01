<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\History;
use App\Models\Reservations;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    public function mapData(Request $request, $mac, $lng, $ltd)
    {
        $bike = Bike::where('status', 1)->where('mac_address', $mac)->first();
        if ($bike && $bike->available == 0) {
            $reservation = Reservations::where('status', 1)->where('bike',  $bike->id)->latest()->first();
            if ($reservation) {
                History::create([
                    'bike' => $bike->id,
                    'reservation' => $reservation->id,
                    'lng' => $lng,
                    'ltd' => $ltd,
                    'status' => 1
                ]);
            } else {
                return 2;
            }
        } else {
            return 2;
        }
    }
}
