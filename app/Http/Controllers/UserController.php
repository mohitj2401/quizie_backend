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
                $user->usertype_id = 3;

                $api_token = time() . Str::random(30);

                if (count(User::where('api_token', $user->$api_token)->get()) > 0) {
                    $user->api_token = time() . Str::random(24) . time();
                } else {
                    $user->api_token = $api_token;
                }
                $user->save();
                $data['status'] = '200';
                $data['api_token'] = $user->api_token;
                $data['msg'] = 'Registered User Succesfully , Please Log In';
            } catch (\Throwable $th) {
                $data['status'] = '500';
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

        ], [
            'email.exists' => "No account exist with this email address"
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        } else {
            try {
                $user = User::where('email', $request->email)->where('usertype_id', 3)->where('status', 1)->first();
                if ($user) {
                    if (Hash::check($request->password, $user->password)) {
                        $data['status'] = '200';
                        $data['msg'] = 'Logged In Successfully';
                        $data['api_token'] = $user->api_token;
                    } else {
                        $data['status'] = '203';
                        $data['msg'] = 'incorrect email or password ';
                    }
                } else {
                    $data['status'] = '203';
                    $data['msg'] = 'Account deactivated please contact admin';
                }
            } catch (\Throwable $th) {
                $data['status'] = '500';
                $data['msg'] = 'Please Try Again After Some Time';
                $data['th'] = $th;
            }
            return response()->json($data);
        }
    }

    public function getUser($api_token)
    {
        if ($api_token) {
            $user = User::where('api_token', $api_token)->withCount('result')->first();
            if ($user) {

                try {
                    $data['user'] = $user;

                    $data['status'] = '200';
                    $data['msg'] = 'All Quizzes';
                } catch (\Throwable $th) {
                    $data['status'] = '500';
                    $data['msg'] = 'Please Try Again After Some Time';
                    $data['th'] = $th;
                }
            } else {
                $data['status'] = '511';
                $data['msg'] = 'User Not Found';
            }
        }
        return response()->json($data);
    }

    public function updateUser(Request $request, $api_token)
    {
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {
                try {
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->save();
                    $data['status'] = '200';
                    $data['api_token'] = $user->api_token;
                    $data['msg'] = 'User detail Updated Successfully';
                } catch (\Throwable $th) {
                    $data['status'] = '500';
                    $data['msg'] = 'Please Try Again After Some Time';
                    $data['th'] = $th;
                }
            } else {
                $data['status'] = '511';
                $data['msg'] = 'User Not Found';
            }
        }
        return response()->json($data);
    }
    public function updatePass(Request $request, $api_token)
    {
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {

                try {

                    if ($user) {
                        if (Hash::check($request->old_pass, $user->password)) {
                            $user->password = Hash::make($request->new_pass);
                            $user->save();
                            $data['status'] = '200';
                            $data['msg'] = 'Logged In Successfully';
                            $data['api_token'] = $user->api_token;
                        } else {
                            $data['status'] = '203';
                            $data['msg'] = "Old Password Doesn't not match. plaese try again!";
                        }
                    } else {
                        $data['status'] = '201';
                        $data['msg'] = 'Account deactivated please contact admin';
                    }
                } catch (\Throwable $th) {
                    $data['status'] = '500';
                    $data['msg'] = 'Please Try Again After Some Time';
                    $data['th'] = $th;
                }
            } else {
                $data['status'] = '511';
                $data['msg'] = 'User Not Found';
            }
        }
        return response()->json($data);
    }
}
