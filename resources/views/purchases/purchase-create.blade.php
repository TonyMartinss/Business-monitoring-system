@extends('layouts.master')

@section('title', 'Create Purchase')
@section('page-heading', 'Register New Purchase')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-header"><strong>Add New Purchase</strong></div>
        <div class="card-body">
            <form action="{{ route('purchase.store') }}" method="POST">
                @csrf

                <!-- Product Selection -->
                  <div class="mb-3">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" class="form-control" min="1" required>
                </div>
                
                
                <div class="mb-3">
                    <label for="product_id">Select Product</label>
                    <select name="product_id" id="product_id" class="form-control" required>
                        <option value="">-- Select Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} (Stock: {{ $product->quantity }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity -->
                <div class="mb-3">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                </div>

                <!-- Unit Price -->
                <div class="mb-3">
                    <label for="unit_price">Unit Price (Tsh)</label>
                    <input type="number" name="unit_price" id="unit_price" class="form-control" step="0.01" required>
                </div>

                <!-- Total Amount (auto-calculated) -->
                <div class="mb-3">
                    <label for="total_amount">Total Amount (Tsh)</label>
                    <input type="number" name="total_amount" id="total_amount" class="form-control" step="0.01" readonly required>
                </div>

                <!-- Account Selection -->
                <div class="mb-3">
                    <label for="account_id" class="form-label">Select Account</label>
                    <select name="account" id="account_id" class="form-control" required>
                        <option value="">-- Select Account --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Supplier Info (Optional) -->
                <div class="mb-3">
                    <label for="supplier_name">Supplier Name</label>
                    <input type="text" name="supplier_name" id="supplier_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="supplier_phone">Supplier Phone</label>
                    <input type="text" name="supplier_phone" id="supplier_phone" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Save Purchase</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const quantity = document.getElementById('quantity');
    const unitPrice = document.getElementById('unit_price');
    const totalAmount = document.getElementById('total_amount');

    function calculateTotal() {
        const qty = parseFloat(quantity.value) || 0;
        const price = parseFloat(unitPrice.value) || 0;
        totalAmount.value = (qty * price).toFixed(2);
    }

    quantity.addEventListener('input', calculateTotal);
    unitPrice.addEventListener('input', calculateTotal);
</script>
@endpush
@endsection
