<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use App\Notifications\VerifyEmail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $user = session('user');
        $code = $request->input('code');
        if (!$code == $user->remember_token) {
            throw ValidationException::withMessages(['code' => 'Invalid Code!']);
        }
        if (!is_null($user->email_verified_at)) {
            throw ValidationException::withMessages(['code' => 'Email already verified!']);
        }
        $user->email_verified_at = now();
        $user->save();
        request()->session()->regenerate();
        Auth::login($user);
        return redirect('/home');
    }

    public function resendCode(Request $request)
    {
        $user = session('user');
        $purpose = 'resend';
        Mail::to($user)->send(new VerificationMail($user, $purpose));
        return redirect('/verification')->with(['sent' => 'A code has been sent to your mail']);
    }
    public function showCodeVerification(Request $request)
    {
        $user = session('user');
        return view('auth.codeVerification', ['user' => $user]);
    }
}
