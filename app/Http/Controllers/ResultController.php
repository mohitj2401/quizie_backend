<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function store(Request $request, $api_token)
    {
        // $encode=json_encode($request->data1);
        // $decode=json_decode($encode);
        $data = array();
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {
                try {
                    $result = new Result;

                    $result->results = $request['data1'];
                    $result->user_id = $user->id;
                    $result->notAttempted = $request['notAttempted'];
                    $result->total = $request['total'];
                    $result->incorrect = $request['incorrect'];
                    $result->correct =$request['correct'];
                    $result->quiz_id = $request['quizId'];
                    $result->save();
                    $data['status'] = '200';
                    $data['msg'] = 'Result Stored Successfully';
                } catch (\Throwable $th) {
                    $data['status'] = '500';
                    $data['msg'] = $th;
                }
            } else {
                $data['status'] = '404';
                $data['msg'] = 'User Not Found';
            }
        }
        return $data;
    }
}
