<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class APIUserController extends Controller
{

    use ResponseTrait;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }
        $user = User::where('usertype', 3)->where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return $this->successResponse(code: 200, data: ['user' => $user, 'stores' => Store::where('status', 1)->get()]);
            } else {
                return $this->errorResponse(code: 422, data: 'Credentials mismatch');
            }
        } else {
            return $this->errorResponse(code: 422, data: 'Credentials mismatch');
        }
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'unique:users|required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ];

        $input = $request->only('name', 'email', 'password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }
        $name = $request->name;
        $email    = $request->email;
        $password = $request->password;
        User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
        return $this->successResponse();
    }
}
