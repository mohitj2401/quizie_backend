<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class QuizController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['active'] = 'quiz';
        $data['title'] = 'Quiz List | Quizie';
        $data['quizzes'] = auth()->user()->quiz;
        return view('admin.quiz', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['active'] = 'quiz';
        $data['title'] = 'Create Quiz | Quizie';
        $data['subjects'] = auth()->user()->subjects->where('status', 1);
        return view('admin.quizcreate', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'required|image|mimes:png,jpg',
            'subject' => 'required|bail'
        ]);
        $quiz = new Quiz();
        $quiz->description = $request->description;
        $quiz->title = $request->title;
        $quiz->duration = $request->duration;
        $quiz->access_token = Str::random(8);
        $quiz->subject_id = $request->subject;
        $quiz->start_time = $request->start_date;
        $quiz->end_time = $request->end_date;
        $imageName = time() . '.' . $request->image->extension();

        Storage::putFileAs('public\quiz', $request->image, $imageName);

        // $quiz->image = Storage::url('quiz\\' . $imageName);
        $quiz->image = 'quiz/' . $imageName;
        auth()->user()->quiz()->save($quiz);
        alert()->success('Quiz Created Succesfully');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        $data['quiz'] = $quiz;
        $data['active'] = 'quiz';
        $data['title'] = 'Edit Quiz | Quizie';
        $data['subjects'] = auth()->user()->subjects;
        return view('admin.quizview', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'image|mimes:png,jpg',
        ]);
        // $path = Storage::exists($path);
        // dd(Storage::exists('public/' . $quiz->image));
        if ($request->image) {
            if (Storage::exists('public/' . $quiz->image)) {

                Storage::delete('public/' . $quiz->image);
            }
            $imageName = time() . '.' . $request->image->extension();

            Storage::putFileAs('public\quiz', $request->image, $imageName);

            // $quiz->image = Storage::url('quiz\\' . $imageName);
            $quiz->image = 'quiz/' . $imageName;
        }


        $quiz->description = $request->description;
        $quiz->title = $request->title;
        $quiz->subject_id = $request->subject;
        $quiz->duration = $request->duration;
$quiz->start_time = $request->start_date;
        $quiz->end_time = $request->end_date;
        $quiz->save();
        alert()->success('Quiz Updated Succesfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        if (Storage::exists('public/' . $quiz->image)) {

            Storage::delete('public/' . $quiz->image);
        }
        $quiz->delete();
        alert()->success('Quiz Deleted Succesfully');

        return back();
    }
}
