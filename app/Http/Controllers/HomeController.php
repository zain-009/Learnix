<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function showHome()
    {
        $user = Auth::user();
        $teaching = ClassModel::where('teacherId',$user->id)->get();
        $enrolled = Auth::user()->classes;
        return view('home',['teaching' => $teaching, 'enrolled' => $enrolled]);
    }
}
