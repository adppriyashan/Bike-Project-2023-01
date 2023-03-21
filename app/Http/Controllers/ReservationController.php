<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Reservations;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    use ResponseTrait;

    public function checkAvailabilityByQRCode(Request $request)
    {
        $code = base64_decode($request->code);
        error_log($code);
        $bike = Bike::where('status', 1)->where('mac_address',  $code)->first();
        error_log(json_encode($bike));
        if ($bike && $bike->available == 0 && Reservations::where('user', $request->user)->where('status', 1)->where('bike', $bike->id)->first()) {
            $distance = (new BikeController)->distance($request->ltd, $request->lng, $bike->ltd, $bike->lng, 'K');
            return $this->successResponse(data: ['distance' => $distance, 'price' => format_currency($distance * env('1KMTOTAL'))]);
        }

        if ($bike && $bike->available == 1) {
            $distance = (new BikeController)->distance($request->ltd, $request->lng, $bike->ltd, $bike->lng, 'K');
            return $this->successResponse(data: ['distance' => $distance, 'price' => format_currency($distance * env('1KMTOTAL'))]);
        } else {
            return $this->errorResponse(code: 400, data: 'This ride is not available');
        }
    }

    public function reserveByQRCode(Request $request)
    {
        try {
            $code = base64_decode($request->code);
            $user = $request->user;
            $cardLastNumbers = $request->last_card;

            $bike = Bike::where('status', 1)->where('mac_address',  $code)->first();

            $reservation = Reservations::where('is_paid', 2)->where('user', $request->user)->where('status', 1)->where('bike', $bike->id)->first();

            if ($request->has('temp') && $request->temp != '' && !($reservation)) {
                return $this->errorResponse(code: 400, data: 'Reservation cannot complete');
            } else if (!$bike && $bike->available == 1) {
                return $this->errorResponse(code: 400, data: 'Reservation cannot complete');
            }

            if ($request->has('temp') && $request->temp != '' && $reservation) {
                $reservation->update([
                    'card_last_numbers' => $cardLastNumbers,
                    'status' => 1,
                    'is_paid' => 1,
                ]);
            } else {

                $reservation = Reservations::where('status', 1)->where('bike',  $bike->id)->first();
                if ($reservation)
                    return $this->errorResponse(code: 400, data: 'Reservation already exists.');

                Reservations::create([
                    'bike' => $bike->id,
                    'user' => $user,
                    'status' => 1,
                    'ride_at' =>    Carbon::now(),
                    'is_paid' => 1,
                    'card_last_numbers' => $cardLastNumbers,
                    'from_lng' => $request->from_lng,
                    'from_ltd' => $request->from_ltd,
                    'to_lng' => $request->to_lng,
                    'to_ltd' => $request->to_ltd,
                ]);
            }

            $bike->update(['available' => 2]);
            return $this->successResponse(data: 'Payment complete, You can ride now');
        } catch (Exception $th) {
            error_log($th->getMessage());
        }
    }

    public function reserveByHour(Request $request)
    {
        DB::beginTransaction();
        try {
            $code = base64_decode($request->code);
            $user = $request->user;
            $rideAt = $request->ride_at;
            $bike = Bike::where('status', 1)->where('available', 1)->where('mac_address',  $code)->first();

            if (!$bike)
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
                'is_paid' => 2,
                'from_lng' => $request->from_lng,
                'from_ltd' => $request->from_ltd,
                'to_lng' => $request->to_lng,
                'to_ltd' => $request->to_ltd,
            ]);

            $bike->update(['available' => 2]);

            DB::commit();
            return $this->successResponse(data: 'Reservation Temporary Completed For 1 Hour From Now');
        } catch (Exception $th) {
            DB::rollBack();
            error_log($th->getMessage());
        }
    }
}
