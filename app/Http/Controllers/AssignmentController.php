<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
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
}
