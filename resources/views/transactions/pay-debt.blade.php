@extends('layouts.master')

@section('title', 'Pay Debt')
@section('page-heading', 'Pay Outstanding Debt')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-header">
            <strong>Pay Debt for Transaction #{{ $transaction->id }}</strong>
        </div>
        <div class="card-body">
            <p><strong>Customer:</strong> {{ $transaction->customer_name ?? '-' }}</p>
            <p><strong>Item:</strong> {{ $transaction->item->name ?? '-' }}</p>
            <p><strong>Total Price:</strong> {{ number_format($transaction->total_price, 2) }}</p>
            <p><strong>Amount Paid:</strong> {{ number_format($transaction->paid_amount, 2) }}</p>
            <p><strong>Balance:</strong> {{ number_format($transaction->balance, 2) }}</p>

            <form action="{{ route('transactions.payDebt', $transaction->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="amount">Amount to Pay</label>
                    <input type="number" name="amount" id="amount" class="form-control" 
                        max="{{ $transaction->balance }}" min="1" required>
                </div>

                 <!-- Payment Method dropdown -->
                <div class="mb-3">
                        <label for="account_id">Select Account</label>
                        <select name="account_id" id="account_id" class="form-control" required>
                            <option value="">-- Select Account --</option>
                            
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">-- {{ $account->name }} --</option>
                            @endforeach
                        </select>
                    </div>

                <button type="submit" class="btn btn-success">Submit Payment</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
