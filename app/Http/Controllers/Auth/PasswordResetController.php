<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    public function showForgotPassword()
    {
        return view('auth.passwords.forgot-password');
    }

    public function sendResetPasswordLink(Request $request)
    {
        $validated = request()->validate([
            'email' => ['required', 'email', 'exists:users'],
        ]);
        $email = $validated['email'];
        $user = User::where('email', $email)->first();
        $user->remember_token = Str::random(6);
        $user->save();
        $purpose = 'passwordReset';
        Mail::to($email)->send(new VerificationMail($user, $purpose));
        return view('auth.passwordCodeVerification', ['email' => $email]);
    }

    public function verifyPasswordCode(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required'],
        ]);
        $email = $validated['email'];
        $code = $validated['code'];
        $user = User::where('email', $email)->first();
        if (!$code == $user->remember_token) {
            throw ValidationException::withMessages(['code' => 'Invalid Code!']);
        }
        $request->session()->put('reset_email', $email);
        return redirect('/resetPassword');
    }

    public function showResetPassword(Request $request)
    {
        $email = $request->session()->get('reset_email');
        return view('auth.passwords.reset-password',['email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $validated = request()->validate([
            'password' => ['required', 'confirmed', 'min:4'],
            'email' => ['required', 'email'],
        ]);

        $email=$validated['email'];
        $password=$validated['password'];

        $user = User::where('email', $email)->first();
        $user->password = Hash::make($password);
        $user->save();

        request()->session()->regenerate();
        return redirect('/login');
    }
}
