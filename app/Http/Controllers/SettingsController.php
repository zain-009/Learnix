<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    public function showSettings()
    {
        $user = request()->user();
        return view('settings',['user' => $user]);
    }

    public function deleteAccount(Request $request)
    {
        $attributes = request()->validate([
            'password' => 'required',
        ]);
        $user = Auth::user();
        if(Hash::check($attributes['password'], $user->password)){
            Auth::logout();
            $user->delete();
            return redirect('/login');
        } else {
            throw ValidationException::withMessages(['password' => 'Incorrect Password']);
        }

    }
}
