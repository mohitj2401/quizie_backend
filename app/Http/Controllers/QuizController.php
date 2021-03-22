<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class QuizController extends Controller
{
    public function store(Request $request, $api_token)
    {
        $validate = Validator($request->all(), [
            'title' => 'required',
            'image' => 'image|required|mimes:jpg,jpeg,png',

        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        } else {
            if ($api_token) {
                $user = User::where('api_token', $api_token)->first();
                if ($user) {
                    try {
                        $quiz = new Quiz;
                        $quiz->title = $request->title;
                        $quiz->description = $request->description;

                        $imageName = time() . '.' . $request->image->extension();

                        Storage::putFileAs('public\quiz', $request->image, $imageName);

                        // $quiz->image = Storage::url('quiz\\' . $imageName);
                        $quiz->image = 'quiz/' . $imageName;
                        $user->quiz()->save($quiz);
                        $data['status'] = '200';
                        $data['quiz_id'] = $quiz->id;
                        $data['msg'] = 'Quiz Stored Successfully';
                    } catch (\Throwable $th) {
                        $data['status'] = '401';
                        $data['msg'] = 'Please Try Again After Some Time';
                        $data['th'] = $th;
                    }
                } else {
                    $data['status'] = '404';
                    $data['msg'] = 'User Not Found';
                }
            }

            return response()->json($data);
        }
    }
    public function getQuiz($api_token)
    {
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {
                try {
                if (count($user->quiz) > 0) {
                    $data['data'] = $user->quiz()->withCount('question')
                        ->get();
                }
                if($user->usertype_id==3){
                    $quiz_ids=$user->result->pluck('quiz_id');
                    $data['data'] = Quiz::whereNotIn('id',$quiz_ids)->has('question', '>' , 0)->withCount('question')
                        ->get();
                }

                $data['status'] = '200';
                $data['msg'] = 'All Quizzes';
                } catch (\Throwable $th) {
                    $data['status'] = '401';
                    $data['msg'] = 'Please Try Again After Some Time';
                    $data['th'] = $th;
                }
            } else {
                $data['status'] = '404';
                $data['msg'] = 'User Not Found';
            }
        }
        return response()->json($data);
    }
    public function deleteQuiz($api_token, Quiz $quiz)
    {
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {

                try {

                    Storage::delete('public\\' . $quiz->image);
                    $quiz->delete();

                    $data['status'] = '200';
                    $data['msg'] = 'quiz Deleted Successfully';
                } catch (\Throwable $th) {
                    $data['status'] = '401';
                    $data['msg'] = 'Please Try Again After Some Time';
                    $data['th'] = $th;
                }
            } else {
                $data['status'] = '404';
                $data['msg'] = 'Please Login Again';
                $data['th'] = $th;
            }
        } else {
            $data['status'] = '401';
            $data['msg'] = 'Please Try Again After Some Time';
        }
        return response()->json($data);
    }
}
