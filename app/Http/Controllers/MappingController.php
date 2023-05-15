<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\FactorHistory;
use App\Models\History;
use App\Models\Reservations;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    public function mapData(Request $request, $mac, $lng, $ltd)
    {
        $bike = Bike::where('status', 1)->where('mac_address', $mac)->first();
        if ($bike && $bike->available == 1) {
            $reservation = Reservations::where('status', 1)->where('bike',  $bike->id)->latest()->first();
            if ($reservation) {
                History::create([
                    'bike' => $bike->id,
                    'reservation' => $reservation->id,
                    'lng' => $lng,
                    'ltd' => $ltd,
                    'status' => 1
                ]);

                $bike->update([
                    'lng' => $lng,
                    'ltd' => $ltd
                ]);

                return $bike->locked == 1 ? 1 : 0;
            } else {
                return 2;
            }
        } else {
            return 2;
        }
    }

    public function factorData(Request $request, $mac, $intensity, $temperature, $humidity, $air_quality, $rainy, $waterlevel)
    {
        $bike = Bike::where('status', 1)->where('mac_address', $mac)->first();
        if ($bike) {
            FactorHistory::create([
                'bike' => $bike->id,
                'intensity' => $intensity,
                'temperature' => $temperature,
                'humidity' => $humidity,
                'air_quality' => $air_quality,
                'rainy' => $rainy,
                'waterlevel' => $waterlevel
            ]);

            $bike->update([
                'intensity' => $intensity,
                'temperature' => $temperature,
                'humidity' => $humidity,
                'air_quality' => $air_quality,
                'rainy' => $rainy,
                'waterlevel' => $waterlevel
            ]);

            return 1;
        } else {
            return 2;
        }
    }
}
