<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function uploadAssignment(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:50000',
            'title' => 'required',
            'duration' => 'required',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/assignments');

            $assignment = new Assignment();
            $assignment->title = $request->input('title');
            $assignment->file = $path;
            $assignment->duration = $request->input('duration');
            $assignment->class_id = $request->input('classId');
            if ($request->input('instructions') != '') {
                $assignment->instructions = $request->input('instructions');
            }
            $assignment->save();
            return redirect()->back();
        }
    }

    public function deleteAssignment(Request $request)
    {
        $assignment = Assignment::find($request->input('assignmentId'));

        if ($assignment) {
            if (Storage::exists($assignment->file)) {
                Storage::delete($assignment->file);
            }

            $assignment->delete();

            return redirect()->back();
        }
    }
    public function submitAssignment(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:50000',
        ]);

        $assignment = Assignment::find($request->input('assignmentId'));

        $deadline = $assignment->created_at->addDays($assignment->duration);

        $isOnTime = now()->lessThanOrEqualTo($deadline);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/assignmentSubmissions');
    
            $assignmentSubmission = new AssignmentSubmissions();
            $assignmentSubmission->assignment_id = $assignment->id;
            $assignmentSubmission->turn_in_time = $isOnTime ? 'on_time' : 'late';
            $assignmentSubmission->user_id = auth()->user()->id;
            $assignmentSubmission->file = $path;
            $assignmentSubmission->submitted = true;
            $assignmentSubmission->save();
    
            return redirect()->back();
        }
    }
}
