<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmissions;
use App\Models\ClassModel;
use App\Models\Quiz;
use App\Models\QuizSubmissions;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function submissions(Request $request,) {
        $request->validate([
            'type' => 'required',
            'id' => 'required',
            'classId' => 'required',
        ]);

        $type = $request->input('type');
        $id = $request->input('id');
        $class = ClassModel::where('id', $request->input('classId'))->first();

        if ($type == 'assignment') {
            $submissions = AssignmentSubmissions::where('assignment_id', $id)->with('user')->get();
            $assignment = Assignment::where('id',$id)->first();
            $count = AssignmentSubmissions::where('assignment_id', $id)->count();
            return view('submissions',[
                'type' => 'Assignment',
                'submissions' => $submissions,
                'assignment' => $assignment,
                'class' => $class,
                'count' => $count,
            ]);

        } elseif ($type == 'quiz') {
            $submissions = QuizSubmissions::where('quiz_id', $id)->with('user')->get();
            $quiz = Quiz::where('id',$id)->first();
            $count = QuizSubmissions::where('quiz_id', $id)->count();
            return view('submissions',[
                'type' => 'Quiz',
                'submissions' => $submissions,
                'quiz' => $quiz,
                'class' => $class,
                'count' => $count,
            ]);
        } else {
            return redirect()->back();
        }
    }
}
