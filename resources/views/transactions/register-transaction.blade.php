@extends('layouts.master')

@section('title', 'Register Transaction')
@section('page-heading', 'Add New Transaction')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-header">Add Transaction</div>
        <div class="card-body">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf

                <!-- Select Product -->
                <div class="mb-3">
                    <label for="product_id">Select Product</label>
                    <select name="product_id" id="product_id" class="form-control" required>
                        <option value="">-- Select Product --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }} 
                                (Stock: {{ $item->quantity }} - 
                                @if($item->quantity < 10) <span style="color:red">Out of Stock</span> @else In Stock @endif
                                )
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity -->
                <div class="mb-3">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                </div>

                <!-- Customer Info -->
                <div class="mb-3">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Optional">
                </div>

                <div class="mb-3">
                    <label for="customer_phone">Customer Phone</label>
                    <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="Optional">
                </div>

                <!-- Paid Amount -->
                <div class="mb-3">
                    <label for="paid_amount">Paid Amount (Tsh)</label>
                    <input type="number" name="paid_amount" id="paid_amount" class="form-control" min="0" required>
                </div>

                <button type="submit" class="btn btn-success">Save Transaction</button>
            </form>
        </div>
    </div>
</div>

<!-- Optional: Live stock check using JS -->
<script>
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');

    productSelect.addEventListener('change', () => {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const stockText = selectedOption.text.match(/Stock: (\d+)/);
        if (stockText) {
            const stock = parseInt(stockText[1]);
            quantityInput.max = stock; // Prevent ordering more than stock
        }
    });
</script>
@endsection
