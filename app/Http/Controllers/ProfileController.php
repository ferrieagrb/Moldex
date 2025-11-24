<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updatePhoto(Request $request)
{
    $request->validate([
        'profile_photo' => 'required|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $file = $request->file('profile_photo');
    $filename = time() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('profile_photos'), $filename);

    Auth::user()->update([
        'profile_photo' => $filename
    ]);

    return back()->with('success', 'Profile photo updated!');
}

}
