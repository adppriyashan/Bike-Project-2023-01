<?php

namespace App\Http\Controllers;

use App\Models\MiddlewareDevice;
use App\Models\ShipEmergency;
use App\Models\ShipHistory;
use Carbon\Carbon;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class MiddlewareDeviceController extends Controller
{
    public function index()
    {
        return view('pages.middleware_device');
    }

    public function track(Request $request)
    {
        $middlewareDevices = MiddlewareDevice::where('status', 1)->get();
        foreach ($middlewareDevices as $key => $value) {
            $query1 = ShipHistory::where('middleware_device',$value->id);
            if ($request->has('from') && $request->from != '') {
                $query1->where('created_at', '>=', Carbon::parse($request->from)->format('Y-m-d H:i:s'));
            }
            if ($request->has('to') && $request->to != '') {
                $query1->where('created_at', '<', Carbon::parse($request->to)->format('Y-m-d H:i:s'));
            }
            $middlewareDevices[$key]['valid'] = ($query1->count() > 0);

            $query2 = ShipEmergency::where('middleware_device',$value->id);
            if ($request->has('from') && $request->from != '') {
                $query2->where('created_at', '>=', Carbon::parse($request->from)->format('Y-m-d H:i:s'));
            }
            if ($request->has('to') && $request->to != '') {
                $query2->where('created_at', '<', Carbon::parse($request->to)->format('Y-m-d H:i:s'));
            }
            $middlewareDevices[$key]['valid'] = ($query2->count() > 0);
        }

        return [$middlewareDevices, view('subcontents.track')->render()];
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'lng' => 'required|string|min:2',
            'ltd' => 'required|string|min:2',
            'mac' => 'required|string',
            'status' => 'required|numeric',
            'isnew' => 'required|numeric',
            'record' => 'nullable|numeric',
        ]);

        $data = [
            'name' => $request->name,
            'lng' => $request->lng,
            'ltd' => $request->ltd,
            'mac' => $request->mac,
            'status' => $request->status
        ];


        if ($request->isnew == 1) {
            MiddlewareDevice::create($data);
        } else {
            MiddlewareDevice::where('id', $request->record)->update($data);
        }

        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:middleware_devices,id'
        ]);

        MiddlewareDevice::where('id', $request->id)->update(['status' => 3]);
        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'Successfully Removed']);
    }

    public function list(Request $request)
    {
        return Laratables::recordsOf(MiddlewareDevice::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ships,id'
        ]);
        return MiddlewareDevice::where('id', $request->id)->first();
    }

    public function get(Request $request)
    {
        $query = MiddlewareDevice::where('status', 1);
        if ($request->has('search') && $request->filled('search'))
            $query->where('location', 'LIKE', '%' . trim($request->search) . '%');

        return $query->orderBy('id', 'DESC')->get();
    }
}
