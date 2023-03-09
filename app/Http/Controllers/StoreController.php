<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StoreController extends Controller
{
    public function index()
    {
        return view('pages.stores');
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'address' => 'required|string',
            'lng' => 'required|numeric',
            'ltd' => 'required|numeric',
            'informations' => 'nullable|string',
            'owner' => 'required_unless:isnew,2|string|exists:users,email',
            'isnew' => 'required|numeric',
            'record' => 'nullable|numeric',
        ]);

        $user = User::where('usertype', 2)->where('email', $request->owner)->first();
        if ($request->isnew == 1 && !$user) {
            throw ValidationException::withMessages(['owner' => 'Invalid Account']);
        }

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'lng' => $request->lng,
            'ltd' => $request->ltd,
            'informations' => $request->informations,
            'status' => 1
        ];


        if ($request->isnew == 1) {
            $data['owner']=$user->id;
            Store::create($data);
        } else {
            Store::where('id', $request->record)->update($data);
        }

        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:stores,id'
        ]);

        Store::where('id', $request->id)->update(['status' => 2]);
        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'Successfully Removed']);
    }

    public function list(Request $request)
    {
        return Laratables::recordsOf(Store::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:stores,id'
        ]);
        $data = Store::where('id', $request->id)->first();
        $data['owner'] = User::where('status',1)->where('usertype', 2)->where('id', $data->owner)->first()->email ?? 'zz';
        return $data;
    }
}
