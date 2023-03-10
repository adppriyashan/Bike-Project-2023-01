<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Reservations;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use ResponseTrait;

    public function checkAvailabilityByQRCode(Request $request)
    {
        error_log($request->code);
        $code = base64_decode($request->code);
        error_log($code);
        $bike = Bike::where('status', 1)->where('mac_address',  $code)->first();
        if ($bike && $bike->available == 1) {
            return $this->successResponse();
        } else {
            return $this->errorResponse(code: 400, data: 'This ride is not available');
        }
    }
    public function reserveByQRCode(Request $request)
    {
        $code = base64_decode($request->code);
        $user = base64_decode($request->user);
        $bike = Bike::where('status', 1)->where('mac_address',  $code)->first();
        if ($bike && $bike->available == 1) {
            $reservation = Reservations::where('status', 1)->where('bike',  $bike->id)->first();
            if ($reservation) {
                return $this->errorResponse(code: 400, data: 'Reservation already exists.');
            } else {
                Reservations::create([
                    'bike' => $bike->id,
                    'user' => $user,
                    'status' => 1,
                ]);
                return $this->successResponse(data: 'Reservation Complete');
            }
        } else {
            return $this->errorResponse(code: 400, data: 'Reservation cannot complete');
        }
    }
}
