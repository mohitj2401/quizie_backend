<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Imports\ImportQuestions;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
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
        $data['quizzes'] = auth()->user()->quiz;
        $data['selectedQuiz'] = '';
        return view('admin.question', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['selectedQuiz'] = '';
        $data['quizzes'] = auth()->user()->quiz;

        return view('admin.questioncreate', $data);
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
            'excel' => 'required|mimes:xlsx',
            'quiz' => 'required',
        ]);
        if ($request->hasFile('excel')) {
            $path = $request->file('excel')->getRealPath();
            try {
                Excel::import(new ImportQuestions($request->quiz), $path);


                alert()->success('Data Inserted Successfully');
            } catch (\Throwable $th) {
                alert()->error('Please check excel file', 'An Error Occur');
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Quiz $quiz)
    {
        $question->delete();
        alert()->success('Deleted');
        session()->put('quiz_id', $quiz->id);
        return redirect()->back();
    }

    public function getQuestion(Quiz $quiz)
    {
        $data['data'] = $quiz->question->toArray();

        return $data;
    }
}
