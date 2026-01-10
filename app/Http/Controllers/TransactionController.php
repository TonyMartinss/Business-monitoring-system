<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\TransactionPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display all transactions with summaries.
     */
    public function index(Request $request)
    {
        // Filter transactions by duration if provided
        $transactionsQuery = Transaction::query();

        if ($request->has('duration')) {
            $duration = $request->duration;
            if ($duration === 'daily') {
                $transactionsQuery->whereDate('created_at', today());
            } elseif ($duration === 'weekly') {
                $transactionsQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($duration === 'monthly') {
                $transactionsQuery->whereMonth('created_at', now()->month);
            }
        } else {
            // Default to current month
            $transactionsQuery->whereDate('created_at', today());
        }

        $transactions = $transactionsQuery->get();

        // Calculate total sales and outstanding debt
        $totalSales = $transactions->sum(function ($t) {
            return $t->payments->sum('amount');
        });

        $outstandingDebt = $transactions->sum('balance');



        return view('transactions.transaction-index', compact(
            'transactions',
            'totalSales',
            'outstandingDebt',
        ));
    }

    /**
     * Show the form to create a new transaction.
     */
    public function create()
    {
        $items = Product::all(); // fetch latest stock
        $accounts = Account::all();
        $customers = Customer::all(); // fetch all customers

        return view('transactions.transaction-create', compact('items', 'accounts', 'customers'));
    }

    /**
     * Store a new transaction and reduce stock.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Products (arrays)
            'product_id'   => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',

            'price'        => 'required|array',
            'price.*'      => 'required|numeric|min:0',

            'qty'          => 'required|array',
            'qty.*'        => 'required|integer|min:1',

            'disc'         => 'nullable|array',
            'disc.*'       => 'nullable|numeric|min:0',

            // Payment
            'paid_amount'  => 'required|numeric|min:0',
            'account_id'   => 'required|exists:accounts,id',

            // Customer
            'customer_name'    => 'nullable|string|max:255',
            'customer_phone'   => 'nullable|string|max:20',
            'customer_address' => 'nullable|string|max:255',
        ]);

        // loop through each product and create individual transactions
        $totalTransactionPrice = 0;

        foreach ($request->product_id as $index => $productId) {
            // Get indiviadual values
            $price = $request->price[$index];
            $quantity = $request->qty[$index];
            $discount = $request->disc[$index] ?? 0;
            $totalPrice = ($price * $quantity) - $discount;
            $totalTransactionPrice += $totalPrice;

            // Reduce stock
            $product = Product::findOrFail($productId);
            record_stock_movement($product->id, 'out', $quantity, 'Sale', Auth::id());

            $product = Product::findOrFail($request->product_id);
            record_stock_movement($product->id, 'out', $request->quantity, 'Sale', Auth::id());

            // Create transaction
            $transaction = Transaction::create([
                'product_id'     => $request->product_id,
                'user_id'        => Auth::id(),
                'quantity'       => $request->quantity,
                'unit_price'     => $product->selling_price,
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
            ]);

            // Record payment
            if ($request->paid_amount > 0) {
                TransactionPayment::create([
                    'transaction_id' => $transaction->id,
                    'user_id'        => Auth::id(),
                    'account_id'     => $request->account_id,
                    'amount'         => $request->paid_amount,
                ]);

                // Record cash movement
                if ($request->has('account_id')) {
                    record_cash_movement('in', $request->paid_amount, $request->account_id, 'Sale Payment');
                }
            }

            return redirect()->route('transactions.index')
                ->with('success', 'Transaction recorded successfully.');
        }
    }

    /**
     * Show form to pay a pending debt.
     */
    public function payDebtForm(Transaction $transaction)
    {
        $accounts = Account::all(); // fetch all accounts from the accounts table
        return view('transactions.pay-debt', compact('transaction', 'accounts'));
    }

    /**
     * Record payment for pending debt.
     */
    public function payDebt(Request $request, Transaction $transaction)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $transaction->balance,
            'account_id' => 'required|exists:accounts,id', // validate account exists
        ]);

        TransactionPayment::create([
            'transaction_id' => $transaction->id,
            'user_id'        => Auth::id(),
            'amount'         => $request->amount,
        ]);

        record_cash_movement(
            'in',                     // type = money IN
            $request->amount,         // amount paid
            $request->account_id, // <-- selected by cashier  // <- chosen account // which account the money goes to
            'Debt payment',           // reason for cash movement
            Auth::id()                // who recorded it
        );

        return redirect()->route('transactions.index')
            ->with('success', 'Debt payment recorded successfully.');
    }



    /**
     * Delete a transaction and restore product stock.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->item) {
            $transaction->item->increment('quantity', $transaction->quantity);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted and stock updated.');
    }
}
