<?php

namespace App\Http\Controllers\Auth;

use App\Mail\VerificationMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SignupController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register()
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email','unique:users', 'max:255'],
            'password' => ['required', 'confirmed', 'max:255'],
        ]);
        $attributes['remember_token'] = Str::random(6);
        $user = User::create($attributes);
        $purpose = 'signup';
        Mail::to($user)->send(new VerificationMail($user, $purpose));
        session(['user'=> $user]);
        return redirect('/verification');
    }
}
