<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $data['quizzes'] = Quiz::all();
        $data['active'] = 'dashboard';
        $data['title'] = 'Dashboard | Quizie';
        return view('admin.index', $data);
    }

    public function showresults()
    {
        $data['results'] = Result::all();
        return view('admin.showresults', $data);
    }

    public function pdfview(Request $request)
    {




        $pdf = PDF::loadView('admin.showresults');

        return $pdf->download('pdfview.pdf');
    }
}
