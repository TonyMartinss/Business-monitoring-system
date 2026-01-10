<?php

namespace App\Http\Controllers;

use App\Models\AssignedUnit;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        // Get all categories and suppliers for filtering or display
        $categories = Category::all();
        $suppliers = Supplier::all();

        // Fetch all products, ignoring soft-deleted items
        $items = Product::with('category', 'supplier')
            ->whereNull('deleted_at')
            ->orderBy('id', 'asc')
            ->get();

        // Calculate total inventory cost and selling
        $totalCost = $items->sum(function ($item) {
            return $item->quantity * $item->purchase_price;
        });

        $totalSelling = $items->sum(function ($item) {
            return $item->quantity * $item->selling_price;
        });

        // Count low stock items (compare per-item quantity vs its reorder_level)
        $lowStockCount = $items->filter(function ($i) {
            return $i->quantity < ($i->reorder_level ?? 0);
        })->count();

        return view('items.product-index', compact(
            'items',
            'lowStockCount',
            'totalCost',
            'totalSelling',
            'categories',
            'suppliers'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $units = Unit::all();
        return view('items.create', compact('categories', 'suppliers', 'units'));
    }

    public function store(Request $request)
    {
        // 1️⃣ Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'reorder_level' => 'required|integer|min:0',
            'damaged_quantity' => 'nullable|integer|min:0',
            'barcode' => 'nullable|string|max:255',
            'expiry_date' => 'nullable',
        ]);

        try {
            // Try to find an existing product by exact name OR barcode (if provided)
            $existingQuery = Product::where('name', $validated['name']);
            if (!empty($validated['barcode'])) {
                // include barcode match as well (so barcode can identify item)
                $existingQuery = Product::where(function ($q) use ($validated) {
                    $q->where('name', $validated['name'])
                        ->orWhere('barcode', $validated['barcode']);
                });
            }
            $existing = $existingQuery->first();

            if ($existing) {
                // Merge: increment quantity and update some fields (keep latest prices/info)
                $existing->increment('quantity', $validated['quantity']);

                $existing->purchase_price = $validated['purchase_price'];
                $existing->reorder_level = $validated['reorder_level'];

                if (isset($validated['category_id'])) {
                    $existing->category_id = $validated['category_id'];
                }
                if (isset($validated['supplier_id'])) {
                    $existing->supplier_id = $validated['supplier_id'];
                }
                if (!empty($validated['barcode'])) {
                    $existing->barcode = $validated['barcode'];
                }
                if (!empty($validated['expiry_date'])) {
                    $existing->expiry_date = $validated['expiry_date'];
                }

                // Ensure damaged_quantity if provided
                if (isset($validated['damaged_quantity'])) {
                    $existing->damaged_quantity = ($existing->damaged_quantity ?? 0) + $validated['damaged_quantity'];
                }

                $existing->save();

                return redirect()->route('items.index')->with('success', 'Existing product found — quantity updated.');
            }

            // No existing product — create new
            $product = Product::create($validated);

            foreach ($request->input('unit', []) as $key => $unitId) {
                $content = $request->input('content')[$key] ?? null;
                $price = $request->input('price')[$key] ?? null;
                
                AssignedUnit::create([
                    'product_id' => $product->id,
                    'unit_id' => $unitId,
                    'content' => $content,
                    'price' => $price,
                ]);
            }

            return redirect()->route('items.index')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to save product: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Product $item)
    {
        $categories = Category::pluck('name', 'id')->prepend('Select Category', '');
        $suppliers = Supplier::pluck('name', 'id')->prepend('Select Supplier', '');
        return view('items.edit', compact('item', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'selling_price' => ['required', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($request) {
                if ($value < $request->input('purchase_price', 0)) {
                    $fail('Selling price must be greater than or equal to purchase price.');
                }
            }],
            'purchase_price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'reorder_level' => 'required|integer|min:1',
            'barcode' => 'nullable|string|max:255|unique:items,barcode,' . $item->id,
            'expiry_date' => 'nullable|date|after:today',
        ]);

        try {
            $item->update($validated);
            return redirect()->route('items.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update item: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Product $item)
    {
        try {
            $item->delete();
            return redirect()->route('items.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete item: ' . $e->getMessage()]);
        }
    }

    public function damage()
    {
        $items = Product::with('category')->where('damaged_quantity', '>', 0)
            ->orWhereNotNull('expiry_date')
            ->paginate(10);
        return view('items.damage', compact('items'));
    }

    public function reportDamage(Request $request, Product $item)
    {
        $validated = $request->validate([
            'damaged_quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($item) {
                    if ($value > $item->quantity) {
                        $fail('Damaged quantity cannot exceed available stock.');
                    }
                },
            ],
        ]);

        try {
            $item->damaged_quantity += $validated['damaged_quantity'];
            $item->quantity = max(0, $item->quantity - $validated['damaged_quantity']);
            $item->save();
            return redirect()->route('items.damage')->with('success', 'Damage reported!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to report damage: ' . $e->getMessage()]);
        }
    }

    public function alerts()
    {
        $items = Product::with('supplier')->whereColumn('quantity', '<', 'reorder_level')
            ->orWhereRaw('expiry_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)')
            ->paginate(10);
        return view('items.alerts', compact('items'));
    }

    public function analytics()
    {
        $items = Product::with('category')->paginate(10);
        $profitData = Product::selectRaw('name, (selling_price - purchase_price) * quantity as total_profit')
            ->whereNotNull('selling_price')
            ->whereNotNull('purchase_price')
            ->orderByDesc('total_profit')
            ->take(10)
            ->get();
        return view('items.analytics', compact('items', 'profitData'));
    }

    public function categories()
    {
        $categories = Category::paginate(10);
        return view('items.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        try {
            Category::create($validated);
            return redirect()->route('items.categories')->with('success', 'Category added!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to add category: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroyCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            if ($category->items()->count() > 0) {
                return redirect()->route('items.categories')->withErrors(['error' => 'Cannot delete category with linked items.']);
            }
            $category->delete();
            return redirect()->route('items.categories')->with('success', 'Category deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete category: ' . $e->getMessage()]);
        }
    }

    public function suppliers()
    {
        $suppliers = Supplier::paginate(10);
        return view('items.suppliers', compact('suppliers'));
    }

    public function storeSupplier(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers',
            'contact_info' => 'nullable|string|max:255',
            'lead_time_days' => 'required|integer|min:1',
        ]);

        try {
            Supplier::create($validated);
            return redirect()->route('items.suppliers')->with('success', 'Supplier added!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to add supplier: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroySupplier($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            if ($supplier->items()->count() > 0) {
                return redirect()->route('items.suppliers')->withErrors(['error' => 'Cannot delete supplier with linked items.']);
            }
            $supplier->delete();
            return redirect()->route('items.suppliers')->with('success', 'Supplier deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete supplier: ' . $e->getMessage()]);
        }
    }
}
