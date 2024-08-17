<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class EnrolledController extends Controller
{
    public function showEnrolled()
    {
        $enrolled = Auth::user()->classes;
        return view('enrolled',['enrolled' => $enrolled]);
    }
}
