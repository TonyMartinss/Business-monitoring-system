<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Account;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of purchases.
     */
    public function index()
    {
        // ✅ Fetch all purchases (latest first)
        $purchases = Purchase::latest()->get();

        // ✅ Calculate total purchase value
        $totalPurchases = $purchases->sum('total_amount');

        // ✅ Pass data to Blade view (index page)
        return view('purchases.purchase-index', compact('purchases', 'totalPurchases'));
    }

    /**
     * Show the form for creating a new purchase.
     */
    public function create()
    {
        // ✅ Return the create form view
        $accounts = Account::all();
        $products = Product::all();
        return view('purchases.purchase-create', compact('accounts', 'products'));
    }

    /**
     * Store a newly created purchase in storage.
     */
    public function store(Request $request)
    {
    
        // ✅ Step 1: Validate user input
        $validated = $request->validate([
            'product_id'     => 'required|exists:products,id',
            'quantity'       => 'required|integer|min:1',
            'unit_price'     => 'required|numeric|min:0',
            'total_amount'   => 'required|numeric|min:0',
            'account'     => 'required|exists:accounts,id',
            'supplier_name'  => 'required|string|max:100',
            'supplier_phone' => [
                'nullable',
                'regex:/^(06|07)\d{8}$/', // Tanzanian mobile format
            ]
        ]);

            // ✅ Step 1: Deduct cash from selected account
        record_cash_movement('out', $request->total_amount, $request->account, $request->notes);

        // ✅ Step 2: Create a new purchase record
        Purchase::create([
            'supplier_name'  => $request->supplier_name,
            'total_amount'   => $request->total_amount,
            'account_id'     => $request->account,
            'purchase_date'  => $request->date ,
            'notes'          => $request->notes ?? null,
        ]);
   
        record_stock_movement(
            $request->product_id,
            'in',
            $request->quantity,
            'Purchase: ' . $request->reference_no
        );


        // ✅ Step 3: Redirect back to index with success message
        return redirect()->route('purchase.index')
            ->with('success', 'Purchase recorded successfully.');
    }

    /**
     * Remove the specified purchase from storage.
     */
    public function destroy(Purchase $purchase)
    {
        // ✅ Delete the selected purchase
        $purchase->delete();

        // ✅ Redirect with success message
        return redirect()->route('purchase.index')
            ->with('success', 'Purchase deleted successfully.');
    }
}
