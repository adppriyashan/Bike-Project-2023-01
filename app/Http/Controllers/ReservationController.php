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
        $bike = null;
        $code = null;
        if ($request->has('code')) {
            $code = base64_decode($request->code);
            $bike = Bike::where('status', 1)->where('mac_address',  $code)->first();
        } else {
            $bike = Bike::where('id',  $request->bikeId)->where('status', 1)->first();
            $code = $bike->mac_address;
        }
        if ($bike && $bike->available == 0 && Reservations::where('user', $request->user)->where('status', 1)->where('bike', $bike->id)->first()) {
            $distance = (new BikeController)->distance($request->ltd, $request->lng, $bike->ltd, $bike->lng, 'K');
            return $this->successResponse(data: ['distance' => $distance, 'price' => format_currency($distance * env('1KMTOTAL')), 'bike' => $code, 'lng' => $bike->lng, 'ltd' => $bike->ltd]);
        }

        if ($bike && $bike->available == 1) {
            $distance = (new BikeController)->distance($request->ltd, $request->lng, $bike->ltd, $bike->lng, 'K');
            return $this->successResponse(data: ['distance' => $distance, 'price' => format_currency($distance * env('1KMTOTAL')), 'bike' => $code, 'lng' => $bike->lng, 'ltd' => $bike->ltd]);
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

                $distance = (new BikeController)->distance($reservation->from_ltd, $reservation->from_lng, $reservation->to_ltd, $reservation->to_lng, 'K');

                $reservation->update([
                    'card_last_numbers' => $cardLastNumbers,
                    'status' => 1,
                    'is_paid' => 1,
                    'distance' => $distance,
                    'total' => $distance * env('1KMTOTAL'),
                ]);
            } else {

                $reservation = Reservations::where('status', 1)->where('bike',  $bike->id)->first();
                if ($reservation)
                    return $this->errorResponse(code: 400, data: 'Reservation already exists.');

                $distance = (new BikeController)->distance($request->from_ltd, $request->from_lng, $request->to_ltd, $request->to_lng, 'K');

                Reservations::create([
                    'bike' => $bike->id,
                    'user' => $user,
                    'distance' => $distance,
                    'total' => $distance * env('1KMTOTAL'),
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

    public function newride(Request $request)
    {
        $this->finishReservation($request);
        return $this->reserveByQRCode($request);
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

    public function finishReservation(Request $request)
    {
        $reservation = Reservations::where('status', 1)->where('id',  $request->id)->first();
        Bike::where('id', $reservation->bike)->update(['available' => '1']);
        $reservation->update(['status' => 2]);
        return $this->successResponse(data: base64_encode(Bike::where('id', $reservation->bike)->first()->mac_address));
    }

    public function historyList(Request $request)
    {
        return $this->successResponse(data: Reservations::where('status', 2)->where('user',  $request->user)->orderBy('created_at', 'DESC')->get());
    }
}
