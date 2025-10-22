<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseMovement;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class ExpenseMovementController extends Controller
{
    /**
     * Display a listing of the expenses.
     */
    public function index()
    {
        // Fetch all expenses with related account and user info
        $expenses = ExpenseMovement::with(['account', 'user'])->latest()->get();

        // Calculate total amount spent
        $totalExpenses = $expenses->sum('amount');

        return view('expenses.expense-index', compact('expenses', 'totalExpenses'));
    }

    /**
     * Show the form to create a new expense.
     */
    public function create()
    {
        // Fetch all accounts for dropdown
        $accounts = Account::all();
        return view('expenses.expense-create', compact('accounts'));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount'     => 'required|numeric|min:0',
            'reason'     => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();

        // 1️⃣ Reduce account cash
        record_cash_movement('out', $request->amount, $request->account_id, $request->reason);

        // 2️⃣ Log expense
        ExpenseMovement::create([
            'amount'     => $request->amount,
            'account_id' => $request->account_id,
            'reason'     => $request->reason,
            'user_id'    => Auth::id(),
        ]);

        return redirect()->route('expense.index')
            ->with('success', 'Expense recorded successfully.');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(ExpenseMovement $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
