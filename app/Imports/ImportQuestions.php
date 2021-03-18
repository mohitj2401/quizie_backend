<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportQuestions implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $quiz_id;

    public function  __construct($report_id)
    {
        $this->quiz_id = $report_id;
    }

    public function model(array $row)
    {
        // dd($this->quiz_id);
        // dd(!Question::where('title', $row['title'])->where('quiz_id', 22)->count() > 0);
        if (!Question::where('title', $row['title'])->where('quiz_id', $this->quiz_id)->count() > 0) {
            return new Question([
                'title' => $row['title'],
                'option1' => $row['option1'],
                'option2' => $row['option2'],
                'option3' => $row['option3'],
                'option4' => $row['option4'],
                'quiz_id' => $this->quiz_id,
            ]);
        }
    }
}
