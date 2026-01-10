<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use App\Models\User; // ✅ make sure this is here

class RegisteredUserController extends Controller
{
    // Show the add-user form
    public function create()
    {
        return view('auth.register');
    }

    // Handle form submission
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ✅ Create user using the imported model (NOT $this->User)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->back()->with('success', 'User added successfully!');
    }
}
