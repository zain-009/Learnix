<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class TeachingController extends Controller
{
    public function showTeaching()
    {
        $user = Auth::user();
        $teaching = ClassModel::where('teacherId',$user->id)->get();
        return view('teaching',['teaching' => $teaching]);
    }
}
