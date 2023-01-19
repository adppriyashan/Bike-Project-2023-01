<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Ship;
use App\Models\ShipEmergency;
use App\Models\ShipHistory;
use App\Models\User;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    public function index()
    {
        $users=User::where('usertype',2)->get();
        return view('pages.ships',compact('users'));
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'no' => 'required|string|min:2',
            'mac' => 'required|string',
            'status' => 'required|numeric',
            'user' => 'required|numeric',
            'isnew' => 'required|numeric',
            'record' => 'nullable|numeric',
        ]);

        $data = [
            'name' => $request->name,
            'no' => $request->no,
            'user' => $request->user,
            'mac' => $request->mac,
            'status' => $request->status
        ];


        if ($request->isnew == 1) {
             Ship::create($data);
        } else {
            Ship::where('id', $request->record)->update($data);
        }

        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ships,id'
        ]);

        Ship::where('id', $request->id)->update(['status' => 3]);
        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'Successfully Removed']);
    }

    public function list(Request $request)
    {
        return Laratables::recordsOf(Ship::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ships,id'
        ]);
        return Ship::where('id', $request->id)->first();
    }

    public function get(Request $request)
    {
        $query = Ship::where('status', 1);
        error_log($request->search);
        if ($request->has('search') && $request->filled('search'))
            $query->where('location', 'LIKE', '%' . trim($request->search) . '%');

        return $query->orderBy('id', 'DESC')->get();
    }

    public function enrollRecords(Request $request){
        ShipHistory::create([
            'ship'=>$request->boat_id,
            'r1'=>$request->r1,
            'r2'=>$request->r2,
            'r3'=>$request->r3,
            'r4'=>$request->r4,
            'smoke'=>$request->smoke,
            'humidity'=>$request->humidity,
            'temperature'=>$request->temperature,
            'distance'=>$request->distance,
            'raindrop'=>$request->raindrop,
            'flame'=>$request->flame,
            'pressure'=>$request->pressure,
            'altituderead'=>$request->altituderead,
            'ltd'=>$request->latitude,
            'lng'=>$request->longitude,
            'range'=>$request->range,
            'ultrasonic'=>$request->ultrasonic,
            'mpu'=>$request->mpu,
            'middleware_device'=>$request->b_id
        ]);
    }

    public function enrollEmergency(Request $request){
        ShipEmergency::create([
            'ship'=>$request->boat_id,
            'message'=>$request->message,
            'lng'=>$request->longitude,
            'ltd'=>$request->latitude,
            'middleware_device'=>$request->b_id
        ]);
    }
}
