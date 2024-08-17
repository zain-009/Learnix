<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class SessionController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/home');
        } else {
            return redirect('/login');
        }
    }

}
