<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
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
}
