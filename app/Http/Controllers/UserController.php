<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateCredentials(Request $request){
        $request->validate([
            'name' => 'required|min:6',
            'email' => 'required|email'
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return redirect('/settings');
    }
}
