<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Reservations;
use App\Models\Store;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BikeController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $stores = [];
        $query = Store::where('status', 1);
        if (Auth::user()->usertype == 1) {
            $stores = $query->with('userData')->get();
        } else {
            $stores = $query->where('owner', Auth::user()->id)->with('userData')->get();
        }
        return view('pages.bikes', compact(['stores']));
    }


    public function getAvailable(Request $request)
    {
        try {
            $ongoing = Reservations::where('user', $request->user)->where('status', 1)->with('bikeData')->first();
            $dataQuery = Bike::where('status', 1);

            if ($ongoing) {
                $dataQuery = $dataQuery->where('id', $ongoing->bike);
            } else {
                $dataQuery = $dataQuery->where('available', 1);
            }

            return $this->successResponse(data: ['ongoing_order' =>  $ongoing ?? 0, 'bikes' => $dataQuery->get()]);
        } catch (Exception $th) {
            error_log($th->getMessage());
        }
    }

    public function getAvailableNearByOrder(Request $request)
    {
        try {
            $data = [];
            if ($request->has('lng') && $request->filled('lng') && $request->has('ltd') && $request->filled('ltd')) {
                foreach (Bike::where('status', 1)->where('available', 1)->get() as $key => $value) {
                    $distance = $this->distance($request->ltd, $request->lng, $value->ltd, $value->lng, 'K');
                    if ($distance < 10) {
                        $value['distance'] =  $distance;
                        $data[] = $value;
                    }
                }
            }
            return $this->successResponse(data: $data);
        } catch (Exception $th) {
            error_log($th->getMessage());
        }
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'mac_address' => 'string',
            'reference' => 'required|string',
            'store' => 'required|numeric',
            'isnew' => 'required|numeric',
            'record' => 'nullable|numeric',
            'status' => 'required|numeric',
        ]);

        $store = Store::where('id', $request->store)->first();

        $data = [
            'store' => $request->store,
            'mac_address' => $request->mac_address,
            'reference' => $request->reference,
            'status' => $request->status,
        ];


        if ($request->isnew == 1) {
            $data['lng'] = $store->lng;
            $data['ltd'] = $store->ltd;
            Bike::create($data);
        } else {
            Bike::where('id', $request->record)->update($data);
        }

        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bikes,id'
        ]);

        Bike::where('id', $request->id)->update(['status' => 3]);
        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'Successfully Removed']);
    }

    public function list(Request $request)
    {
        return Laratables::recordsOf(Bike::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bikes,id'
        ]);
        return Bike::where('id', $request->id)->first();
    }
}
