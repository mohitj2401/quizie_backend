<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
        $data['quizzes'] = Quiz::all();
        return view('admin.quiz', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.quizcreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'required|image|mimes:png,jpg',
        ]);
        $quiz = new Quiz();
        $quiz->description = $request->description;
        $quiz->title = $request->title;
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
