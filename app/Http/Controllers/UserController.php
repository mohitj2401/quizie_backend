<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator($request->all(), [
            'name' => 'required',
            'role' => 'required',

            'email' => 'required|unique:users,email',
            'password' => 'required',

        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        } else {
            try {
                $user = new User;
                $user->name = $request->name;
                $user->password = Hash::make($request->password);
                $user->email = $request->email;
                $user->role = $request->role;

                $api_token = time() . Str::random(30);

                if (count(User::where('api_token', $user->$api_token)->get()) > 0) {
                    $user->api_token = time() . Str::random(24) . time();
                } else {
                    $user->api_token = $api_token;
                }
                $user->save();
                $data['status'] = '200';
                $data['msg'] = 'Registered User Succesfully , Please Log In';
            } catch (\Throwable $th) {
                $data['status'] = '401';
                $data['msg'] = 'Please Try Again After Some Time';
                $data['th'] = $th;
            }
            return response()->json($data);
        }
    }
    public function login(Request $request)
    {
        $validate = Validator($request->all(), [
            'email' => 'required|exists:users,email|email',
            'password' => 'required',

        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        } else {
            try {
                $user = User::where('email', $request->email)->first();
                if (Hash::check($request->password, $user->password)) {
                    $data['status'] = '200';
                    $data['msg'] = 'Logged In Successfully';
                    $data['api_token'] = $user->api_token;
                    $data['role'] = $user->role;
                } else {
                    $data['status'] = '201';
                    $data['msg'] = 'incorrect email or password';
                }
            } catch (\Throwable $th) {
                $data['status'] = '401';
                $data['msg'] = 'Please Try Again After Some Time';
                $data['th'] = $th;
            }
            return response()->json($data);
        }
    }
}
