@extends('layouts.master')

@section('title', 'Create Expense')
@section('page-heading', 'Register New Expense')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-header"><strong>Add New Expense</strong></div>
        <div class="card-body">
            <form action="{{ route('expense.store') }}" method="POST">
                @csrf

                <!-- Account -->
                <div class="mb-3">
                    <label for="account_id" class="form-label">Account</label>
                    <select name="account_id" id="account_id" class="form-control" required>
                        <option value="">-- Select Account --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Amount -->
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                </div>

                <!-- Reason -->
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason / Description</label>
                    <input type="text" name="reason" id="reason" class="form-control" placeholder="e.g., Office supplies, Transport" required>
                </div>

                <button type="submit" class="btn btn-primary">Save Expense</button>
            </form>
        </div>
    </div>
</div>
@endsection
