<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages(['email' => 'Sorry, those credentials donot match!']);
        }
        
        $user = Auth::user();

        if (is_null($user->email_verified_at)) {
            $purpose = "verification";
            Mail::to($user)->send(new VerificationMail($user, $purpose));
            session(['user' => $user]);
            Auth::logout();
            return redirect('/verification');
        }

        request()->session()->regenerate();

        return redirect('/home');
    }
}
