@extends('layouts.master')

@section('title', 'Create Transaction')
@section('page-heading', 'Register New Transaction')

@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-header"><strong>Add New Transaction</strong></div>
            <div class="card-body">
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    <!-- Product Selection -->
                    <div class="mb-3">
                        <label for="product_id">Select Product</label>
                        <select name="product_id" id="product_id" class="form-control" required>
                            <option value="">-- Select Product --</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }} (Stock: {{ $item->quantity }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>

                    <!-- Paid Amount -->
                    <div class="mb-3">
                        <label for="paid_amount">Paid Amount</label>
                        <input type="number" name="paid_amount" id="paid_amount" class="form-control" step="0.01"
                            required>
                    </div>

                    <!-- Account Selection -->
                    <div class="mb-3">
                        <label for="account_id" class="form-label">Select Account</label>
                        <select name="account_id" id="account_id" class="form-control" required>
                            <option value="">-- Select Account --</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Customer Info -->
                    <div class="mb-3">
                        <label for="customer_name">Customer Name</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone">Customer Phone</label>
                        <input type="text" name="customer_phone" id="customer_phone" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success">Save Transaction</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const items = @json($items);
            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const paidInput = document.getElementById('paid_amount');

            // Auto-fill paid amount to total if you want (optional)
            // quantity change can affect total_price if you want dynamic calculation
        </script>
    @endpush
@endsection
