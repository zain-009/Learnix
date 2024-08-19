<?php

namespace App\Http\Controllers;

use App\Models\Announcment;
use App\Models\Assignment;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\User;
use App\Models\ClassUser;
use App\Models\ClassModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClassController extends Controller
{
    public function createClass(Request $request)
    {
        $request->validate([
            'className' => ['required'],
            'section' => ['required'],
        ]);
        $user = Auth::user();
        $className = $request->input('className');
        $section = $request->input('section');
        $teacherId = $user->id;
        $teacherName = $user->name;
        do {
            $classCode = Str::random(6);
        } while (ClassModel::where('classCode', $classCode)->exists());
        ClassModel::create([
            'className' => $className,
            'section' => $section,
            'classCode' => $classCode,
            'teacherName' => $teacherName,
            'teacherId' => $teacherId,
        ]);
        return redirect('/teaching');
    }

    public function joinClass(Request $request)
    {
        $request->validate(['classCode' => ['required', 'max:6', 'min:6']]);
        $user = Auth::user();
        $classCode = request()->input('classCode');
        $class = ClassModel::where('classCode', $classCode)->first();
        if (!$class) {
            return redirect('/home')->withErrors(['classCode' => 'Invalid class code']);
        }
        $hasJoined = $user->classes()->where('classCode', $classCode)->exists();
        if ($hasJoined) {
            throw ValidationException::withMessages(['error' => 'Class already joined']);
        } else {
            $class = ClassModel::where('classCode', $classCode)->firstOrFail();
            $class_user = new ClassUser();
            $class_user->user_id = $user->id;
            $class_user->class_id = $class->id;
            $class_user->save();
            return redirect('/enrolled');
        }
    }

    public function leaveClass(Request $request)
    {
        $user = Auth::user();
        $class = ClassModel::where('id', $request->input('classId'))->first();
        if ($class->teacherId == $user->id) {
            $class->status = 'inActive';
            $class->save();
        } else {
            if ($user) {
                $relation = ClassUser::where('user_id', $user->id)
                    ->where('class_id', $request->input('classId'))
                    ->first();
                $relation->delete();
            }
        }
        return redirect('/home');
    }

    public function showClass($code)
    {
        $class = ClassModel::where('classCode', $code)->first();

        $teacher = User::find($class->teacherId);
        $teacherImage = $teacher ? $teacher->image : null;
        $users = $class->users;

        $announcements = Announcment::where('class_id', $class->id)
            ->orderByDesc('created_at')
            ->get();
        $materials = Material::where('class_id', $class->id)
            ->orderByDesc('created_at')
            ->get();
        $assignments = Assignment::where('class_id', $class->id)
            ->orderByDesc('created_at')
            ->get();
        $quizzes = Quiz::where('class_id', $class->id)
            ->orderByDesc('created_at')
            ->get();

        $mergedItems = $announcements->merge($materials)->merge($assignments)->merge($quizzes)->sortByDesc('created_at');

        return view('class', [
            'class' => $class,
            'teacherImage' => $teacherImage,
            'users' => $users,
            'announcements' => $announcements,
            'materials' => $materials,
            'assignments' => $assignments,
            'quizzes' => $quizzes,
            'mergedItems' => $mergedItems,
        ]);
    }
    public function postAnnouncement(Request $request)
    {
        $request->validate([
            'announcement' => 'required',
        ]);
        $accouncement = new Announcment();
        $accouncement->announcement = $request->input('announcement');
        $accouncement->class_id = $request->input('classId');
        $accouncement->save();
        return redirect()->back();
    }

    public function deleteAnnouncement(Request $request)
    {
        $accouncementId = $request->input('announcementId');
        $accouncement = Announcment::where('id', $accouncementId)->first();
        $accouncement->delete();
        return redirect()->back();
    }
}
