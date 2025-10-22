<!-- resources/views/about.blade.php -->
@extends('layouts.master')

@section('title', 'Create Product')

@section('page-heading', 'Register New Item')

@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-header">

            </div>

            <!-- form to create new product -->
            <form action="{{ route('items.store') }}" method="POST">
                @csrf

                <div class="card-body">
                    <!-- Product Name -->
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        placeholder="e.g. Front Brake Pads" required>

                    <!-- Quantity -->
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="0" min="0">

                    <label for="selling_price">Selling Price</label>
                    <input type="number" name="selling_price" id="selling_price" class="form-control" step="0.01"
                        required>

                    <!-- Purchase Price -->
                    <label for="purchase_price">Purchase Price</label>
                    <input type="number" name="purchase_price" id="purchase_price" class="form-control" step="0.01"
                        required>

                    <!-- Category -->
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">-- {{ $category->name }} --</option>
                        @endforeach
                    </select>

                    <!-- Supplier -->
                    <label for="supplier_id">Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-control">
                        <option value="">-- Select Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">-- {{ $supplier->name }} --</option>
                        @endforeach
                    </select>

                    <!-- Reorder Level -->
                    <label for="reorder_level">Reorder Level</label>
                    <input type="number" name="reorder_level" id="reorder_level" class="form-control" value="10"
                        min="0">

                    <!-- Damaged Quantity -->
                    <label for="damaged_quantity">Damaged Quantity</label>
                    <input type="number" name="damaged_quantity" id="damaged_quantity" class="form-control" value="0"
                        min="0">

                    <!-- Barcode -->
                    <label for="barcode" class="block text-sm font-medium">Barcode</label>
                    <input type="text" name="barcode" id="barcode" class="form-control" placeholder="e.g. ABC123XYZ">

                    <!-- Expiry Date -->
                    <label for="expiry_date">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        // This is where you can add page-specific JavaScript if needed
    </script>
@endpush
