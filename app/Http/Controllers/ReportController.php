<?php

namespace App\Http\Controllers;

use App\Models\CashMovement;
use App\Models\StockMovement;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseMovement;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function expenseReport(Request $request)
    {
        $duration = $request->duration ?? 'daily';
        $expenseMovements = ExpenseMovement::query();

        // Apply duration filter
        if ($duration === 'daily') {
            $expenseMovements->whereDate('created_at', today());
        } elseif ($duration === 'weekly') {
            $expenseMovements->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($duration === 'monthly') {
            $expenseMovements->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        }

        $expensesData = $expenseMovements->get();

        // Calculate totals per account
        $totals = [
            'cash'  => $expensesData->where('account.name', 'Cash')->sum('amount'),
            'bank'  => $expensesData->where('account.name', 'Bank')->sum('amount'),
            'mpesa' => $expensesData->where('account.name', 'Mpesa')->sum('amount'),
        ];

        return view('reports.expense-report', compact('expensesData', 'totals', 'duration'));
    }
      
       public function purchaseReport(Request $request)
     {
        $duration = $request->duration ?? 'daily';
        $purchaseMovements = Purchase::query();

        // Apply duration filter
        if ($duration === 'daily') {
            $purchaseMovements->whereDate('created_at', today());
        } elseif ($duration === 'weekly') {
            $purchaseMovements->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($duration === 'monthly') {
            $purchaseMovements->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        }

        $purchasesData = $purchaseMovements->get();

        // Calculate totals per account
        $totals = [
            'cash'  => $purchasesData->where('account.name', 'Cash')->sum('amount'),
            'bank'  => $purchasesData->where('account.name', 'Bank')->sum('amount'),
            'mpesa' => $purchasesData->where('account.name', 'Mpesa')->sum('amount'),
        ];

        return view('reports.purchase-report', compact('purchasesData', 'totals', 'duration'));
}


    // Stock report (unchanged)
    public function stockReport(Request $request)
    {
        $duration = $request->duration ?? 'daily'; // Default to daily
        $stockMovements = StockMovement::query();

        // Apply duration filter
        if ($duration === 'daily') {
            $stockMovements->whereDate('created_at', today());
        } elseif ($duration === 'weekly') {
            $stockMovements->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($duration === 'monthly') {
            $stockMovements->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        }

        $movements = $stockMovements->with('product')->get();

        return view('reports.stock-report', compact('movements', 'duration'));
    }


    // Cash report with totals
    public function cashReport(Request $request)
    {
        $duration = $request->duration ?? 'daily'; // Default to daily

        $cashMovements = CashMovement::with(['account', 'user']);

        if ($duration === 'daily') {
            $cashMovements->whereDate('created_at', today());
        } elseif ($duration === 'weekly') {
            $cashMovements->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($duration === 'monthly') {
            $cashMovements->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        }

        $movements = $cashMovements->get();

        $totals = [
            'cash'  => $movements->where('account.name', 'Cash')->sum(fn($item) => $item->type === 'in' ? $item->amount : -$item->amount),
            'bank'  => $movements->where('account.name', 'Bank')->sum(fn($item) => $item->type === 'in' ? $item->amount : -$item->amount),
            'mpesa' => $movements->where('account.name', 'Mpesa')->sum(fn($item) => $item->type === 'in' ? $item->amount : -$item->amount),
        ];

        // Update account balances
        foreach (['Cash', 'Bank', 'Mpesa'] as $accountName) {
            $account = Account::where('name', $accountName)->first();
            if ($account) {
                $account->balance = $totals[strtolower($accountName)];
                $account->save();
            }
        }

        return view('reports.cash-report', compact('movements', 'totals', 'duration'));
    }

    // Show form to create new cash movement
    public function createCashMovement()
    {
        $accounts = Account::all(); // Pass accounts for dropdown
        return view('reports.create-cash-movement', compact('accounts'));
    }

    // Store new cash movement
    public function storeCashMovement(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'nullable|string|max:255',
        ]);

        $movement = CashMovement::create([
            'account_id' => $request->account_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'user_id' => Auth::user() ? Auth::user()->id : 1,
        ]);

        // Update account balance immediately
        $account = Account::find($request->account_id);
        if ($movement->type === 'in') {
            $account->balance += $movement->amount;
        } else {
            $account->balance -= $movement->amount;
        }
        $account->save();

        return redirect()->route('cash.report')->with('success', 'Transaction recorded successfully!');
    }
}
