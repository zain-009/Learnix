<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizSubmissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{
    public function uploadQuiz(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'marks' => 'required',
            'duration' => 'required',
            'file' => 'required|file|max:50000',
        ]);
        
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/quizzes');

            $quiz = new Quiz();
            $quiz->title = $request->input('title');
            $quiz->marks = $request->input('marks');
            $quiz->duration = $request->input('duration');
            $quiz->file = $path;
            $quiz->class_id = $request->input('classId');
            if ($request->input('instructions') != '') {
                $quiz->instructions = $request->input('instructions');
            }
            $quiz->save();
            return redirect()->back();
        }
    }

    public function deleteQuiz(Request $request)
    {
        $quiz = Quiz::find($request->input('quizId'));

        if ($quiz) {
            if (Storage::exists($quiz->file)) {
                Storage::delete($quiz->file);
            }

            $quiz->delete();

            return redirect()->back();
        }
    }

    public function submitQuiz(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:50000',
        ]);

        $quiz = Quiz::find($request->input('quizId'));

        $deadline = $quiz->created_at->addHours($quiz->duration);

        $isOnTime = now()->lessThanOrEqualTo($deadline);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/quizSubmissions');
    
            $quizSubmission = new QuizSubmissions();
            $quizSubmission->quiz_id = $quiz->id;
            $quizSubmission->turn_in_time = $isOnTime ? 'on_time' : 'late';
            $quizSubmission->user_id = auth()->user()->id;
            $quizSubmission->file = $path;
            $quizSubmission->submitted = true;
            $quizSubmission->save();
    
            return redirect()->back();
        }
    }
}
