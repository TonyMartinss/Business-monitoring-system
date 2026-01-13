<?php

namespace App\Http\Controllers;

use SweetAlert2\Laravel\Swal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }


    // Admin dashboard
    public function index()
    {
        $users = User::all();
        return view('admins.admin-index', compact('users'));
    }

    // Show create user form
    public function create()
    {
        return view('admins.admin-create'); // your blade
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,admin,boss',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'User created successfully');
    }


    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'User deleted');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admins.admin-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:user,admin,boss',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->save();

       


        return redirect()->route('admin.index')
            ->with('success', 'User updated successfully');
    }
}
