<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\User;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BikeController extends Controller
{
    public function index()
    {
        return view('pages.bikes');
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'mac_address' => 'required|string|unique:bikes,mac_address',
            'reference' => 'required|string',
            'isnew' => 'required|numeric',
            'record' => 'nullable|numeric',
            'status' => 'required|numeric',
        ]);

        $data = [
            'owner' => Auth::user()->id,
            'mac_address' => $request->mac_address,
            'reference' => $request->reference,
            'status' => $request->status
        ];


        if ($request->isnew == 1) {
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
