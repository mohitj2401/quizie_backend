<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['quizzes'] = Quiz::all();
        return view('admin.index', $data);
    }
}
