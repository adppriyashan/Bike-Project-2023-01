<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Reservations;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use ResponseTrait;

    public function checkAvailabilityByQRCode(Request $request)
    {
        $code = base64_decode($request->code);
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
        $rideAt = base64_decode($request->ride_at);
        $cardLastNumbers = base64_decode($request->ride_at);
        $bike = Bike::where('status', 1)->where('mac_address',  $code)->first();

        if ($bike && $bike->available == 1)
            return $this->errorResponse(code: 400, data: 'Reservation cannot complete');

        $reservation = Reservations::where('status', 1)->where('bike',  $bike->id)->first();
        if ($reservation)
            return $this->errorResponse(code: 400, data: 'Reservation already exists.');

        Reservations::create([
            'bike' => $bike->id,
            'user' => $user,
            'status' => 1,
            'ride_at' => $rideAt,
            'is_paid' => 2,
            'card_last_numbers' => $cardLastNumbers
        ]);
        return $this->successResponse(data: 'Reservation Temporary Completed For 1 Hour From Now');
    }

    public function reserveByHour(Request $request)
    {
        $code = base64_decode($request->code);
        $user = base64_decode($request->user);
        $rideAt = base64_decode($request->ride_at);
        $bike = Bike::where('status', 1)->where('mac_address',  $code)->first();

        if ($bike && $bike->available == 1)
            return $this->errorResponse(code: 400, data: 'Reservation cannot complete');

        $reservation = Reservations::where('status', 1)->where('bike',  $bike->id)->first();
        if ($reservation)
            return $this->errorResponse(code: 400, data: 'Reservation already exists.');

        if (Carbon::parse($rideAt)->diffInHours(Carbon::now()) > 1)
            return $this->errorResponse(code: 400, data: 'Non-Payment reservastion must be with in one hour range');

        Reservations::create([
            'bike' => $bike->id,
            'user' => $user,
            'status' => 1,
            'ride_at' => $rideAt,
            'is_paid' => 2
        ]);
        return $this->successResponse(data: 'Reservation Temporary Completed For 1 Hour From Now');
    }
}
