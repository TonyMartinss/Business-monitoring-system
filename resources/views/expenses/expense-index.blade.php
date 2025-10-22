@extends('layouts.master')

@section('title', 'Expenses')
@section('page-heading', 'Expense Records')

@section('content')
<div class="page-content">

    {{-- ✅ Summary Section --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="p-3 bg-light rounded shadow-sm text-center">
                <h6 class="text-muted">Total Expenses (Tsh)</h6>
                <h4 class="fw-bold text-danger">{{ number_format($totalExpenses ?? 0, 2) }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-light rounded shadow-sm text-center">
                <h6 class="text-muted">Number of Records</h6>
                <h4 class="fw-bold">{{ $expenses->count() }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-light rounded shadow-sm text-center">
                <h6 class="text-muted">Last Expense Date</h6>
                <h4 class="fw-bold">
                    {{ $expenses->first() ? $expenses->first()->created_at->format('Y-m-d') : '-' }}
                </h4>
            </div>
        </div>
    </div>

    {{-- ✅ Expenses Table --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Expense Records</h5>
            <a href="{{ route('expense.create') }}" class="btn btn-primary">➕ Add Expense</a>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>S/N</th>
                        <th>Account</th>
                        <th>Amount (Tsh)</th>
                        <th>Reason</th>
                        <th>Recorded By</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $index => $expense)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $expense->account->name ?? '-' }}</td>
                            <td>{{ number_format($expense->amount, 2) }}</td>
                            <td>{{ $expense->reason ?? '-' }}</td>
                            <td>{{ $expense->user->name ?? '-' }}</td>
                            <td>{{ $expense->created_at->format('Y-m-d') }}</td>
                            <td class="text-center">
                                {{-- <form action="{{ route('expense.destroy', $expense->id) }}" method="POST" style="display:inline;"> --}}
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this expense?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="d-flex flex-column align-items-center mb-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" 
                                         alt="No Data" width="64" class="mb-3 opacity-50">
                                    <h5 class="text-muted mb-1">No expenses recorded</h5>
                                    <p class="text-secondary">Click “Add Expense” to start recording expenses.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
