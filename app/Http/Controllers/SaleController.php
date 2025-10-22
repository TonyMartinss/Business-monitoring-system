<?php


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->latest()->paginate(20); // optional paginate
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::whereNull('deleted_at')->orderBy('name')->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($data['quantity'] > $product->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Not enough stock available'])->withInput();
        }

        $selling = $product->selling_price;
        $purchase = $product->purchase_price;
        $total = $selling * $data['quantity'];

        // Save sale
        $sale = Sale::create([
            'product_id' => $product->id,
            'quantity' => $data['quantity'],
            'selling_price' => $selling,
            'purchase_price' => $purchase,
            'total_price' => $total,
        ]);

        // Decrease stock
        $product->decrement('quantity', $data['quantity']);

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully');
    }

    public function show(Sale $sale)
    {
        $sale->load('product');
        return view('sales.show', compact('sale'));
    }
}
