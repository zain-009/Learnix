<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000'
        ]);

        $user = Auth::user();

        if($request->hasFile('image')) {
            if($user->image) {
                Storage::delete($user->image);
            }

            $path = $request->file('image')->store('public/images');
            $user->image = $path;
        }

        $user->save();

        return redirect('/settings');
    }
}
