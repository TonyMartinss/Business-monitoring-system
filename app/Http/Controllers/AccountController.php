<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // List all accounts
    public function index()
    {
        $accounts = Account::all();
        return view('accounts.index', compact('accounts')); // list accounts here
    }

    // Show form to create a new account
    public function create()
    {
        return view('accounts.create');
    }

    // Store new account
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'number' => 'required|string|max:50|unique:accounts,number',
        ]);

        Account::create([
            'name' => $request->name,
            'type' => $request->type,
            'number' => $request->number,
            'balance' => $request->balance ?? 0,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account added successfully.');
    }

    // Show edit form
    public function edit(Account $account)
    {
        return view('accounts.edit', compact('account'));
    }

    // Update account
    public function update(Request $request, Account $account)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'number' => 'required|string|max:50|unique:accounts,number,' . $account->id,
        ]);

        $account->update($request->only(['name', 'type', 'number', 'balance']));

        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    // Delete account
    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
