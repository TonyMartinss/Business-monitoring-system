<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get currently logged-in user
        return view('UserProfile.profile-index', compact('user'));
    }


    public function edit()
    {
        $user = Auth::user();
        return view('UserProfile.profile-edit', compact('user'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        // 1️⃣ Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:password|string',
            'new_password' => 'nullable|required_with:current_password|string|min:8|confirmed',
        ]);

        //  Update basic info
        $user->name = $request->name;
        $user->email = $request->email;

        // If user wants to change password
        if ($request->filled('current_password')) {
            if (! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }

            // Save new password
            $user->password = Hash::make($request->new_password);
        }

        if ($user instanceof User) {
            $user->save();
        }

       

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }
}
