<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Models\SMSModel;
use App\Models\User;
use App\Models\UserType;
use App\Traits\ResponseTrait;
use Exception;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ResponseTrait;

    protected $officerUserType = 4;

    public function index()
    {
        $usertypes = UserType::where('status', 1)->get();
        return view('pages.users', compact(['usertypes']));
    }

    public function find(Request $request)
    {
        $data = [];

        foreach (User::select('id', 'name', 'nic')->where('usertype', $this->officerUserType)->where('status', 1)->where('nic', 'LIKE', '%' . $request->term . '%')
            ->get() as $key => $value) {
            $data[] = ['id' => $value->id, 'text' => $value->name . ' (' . $value->nic  . ')'];
        }

        return $data;
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('routes');
        Session::flush();
        return redirect('/login');
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'isnew' => 'required|in:1,2',
            'name' => 'required|min:1',
            'usertype' => 'required|exists:user_types,id',
            'status' => 'required|in:1,2,3'
        ]);

        if ($request->isnew == 1) {
            $request->validate([
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password',
            ]);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'usertype' => $request->usertype,
                'status' => $request->status,
            ];

            User::create($data);
        } else {
            $request->validate([
                'password' => 'nullable|min:8',
                'password_confirmation' => 'nullable|same:password',
                'record' => 'required|exists:users,id'
            ]);
            $data = [
                'name' => $request->name,
                'usertype' => $request->usertype,
                'status' => $request->status
            ];
            if ($request->has('password') && $request->password != '' && $request->has('password_confirmation')) {
                $data['password'] = Hash::make($request->password);
            }
            User::where('id', $request->record)->update($data);
        }
        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'User Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }

    public function changeStatus($id, $status)
    {
        $user = User::find($id);
        if ($user) {
            $user->update(['status' => $status]);
            return redirect()->back()->with(['resp' => ['msg' => 'User Successfully Updated.', 'color' => 'success']]);
        }
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id'
        ]);
        User::where('id', $request->id)->update(['status' => 4]);

        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'User Successfully Removed']);
    }

    public function list(Request $request)
    {
        return Laratables::recordsOf(User::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id'
        ]);
        return User::where('id', $request->id)->first();
    }

    public function getLeaderBoard()
    {
        $data = User::getLeaderBoard();
        // return $this->successResponse(data: (count($data) == 10) ? $data : []);
        return $this->successResponse(data: $data);
    }

    public function informEmergency(Request $request)
    {

        try {
            $content = '';

            $user = User::where('id', $request->user)->first();

            $content .= '*** EMERGENCY - ' . (($request->type == 'police') ? 'POLICE' : 'HOSPITAL').' *** ';
            $content .= 'NAME : ' . $user->name . ' ';
            $content .= '| EMAIL : ' . $user->email . ' ';

            $reservation = Reservations::where('status', 1)->where('is_paid', 1)->where('user', $request->user)->with('bikeData')->first();

            $content .= '| CURRENT LOCATION : ' . $reservation->bikeData->lng . ', ' . $reservation->bikeData->ltd;

            if ($user && $reservation) {
                (new SMSModel)->send($content, ($request->type == 'police') ? env('POLICE_CONTACT') : env('HOSPITAL_CONTACT'));
            }
        } catch (Exception $th) {
            error_log($th->getMessage());
        }
    }
}
