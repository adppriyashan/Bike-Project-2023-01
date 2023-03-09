<?php

namespace App\Http\Controllers;

use App\Models\Bike;
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


    public function getAvailable()
    {
        try {
            return $this->successResponse(data: Bike::where('status', 1)->where('available', 1)->get());
        } catch (Exception $th) {
            error_log($th->getMessage());
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

        $store=Store::where('id',$request->store)->first();

        $data = [
            'store' => $request->store,
            'mac_address' => $request->mac_address,
            'reference' => $request->reference,
            'status' => $request->status,
        ];


        if ($request->isnew == 1) {
            $data['lng']=$store->lng;
            $data['ltd']=$store->ltd;
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
