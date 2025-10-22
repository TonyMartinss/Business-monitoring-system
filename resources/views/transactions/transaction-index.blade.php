@extends('layouts.master')

@section('title', 'Transactions')
@section('page-heading', 'Sales & Debt Records')

@section('content')
    <div class="page-content">

        {{-- ✅ Summary Section --}}
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="p-3 bg-light rounded shadow-sm text-center">
                    <h6 class="text-muted">Total Sales (Tsh)</h6>
                    <h4 class="fw-bold text-success">{{ number_format($totalSales ?? 0, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light rounded shadow-sm text-center">
                    <h6 class="text-muted">Items Sold</h6>
                    <h4 class="fw-bold">{{ $transactions->sum('quantity') }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light rounded shadow-sm text-center">
                    <h6 class="text-muted">Total Transactions</h6>
                    <h4 class="fw-bold">{{ $transactions->count() }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light rounded shadow-sm text-center">
                    <h6 class="text-muted">Outstanding Debt (Tsh)</h6>
                    <h4 class="fw-bold text-danger">{{ number_format($outstandingDebt ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>

        {{-- ✅ Transactions Table --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sales Records</h5>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary">➕ New Sale</a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>S/N</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price (Tsh)</th>
                            <th>Total Price (Tsh)</th>
                            <th>Paid Amount (Tsh)</th>
                            <th>Remaining (Tsh)</th>
                            <th>Payment Status</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $t)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $t->item->name ?? '-' }}</td>
                                <td>{{ $t->quantity }}</td>
                                <td>{{ number_format($t->unit_price, 2) }}</td>
                                <td>{{ number_format($t->total_price, 2) }}</td>
                                <td>{{ number_format($t->paid_amount, 2) }}</td>
                                <td>{{ number_format($t->balance, 2) }}</td>
                                <td>
                                    @if (!$t->is_cleared)
                                        <a href="{{ route('transactions.showPayDebtForm', $t->id) }}"
                                            class="badge bg-danger text-decoration-none">
                                            Pending
                                        </a>
                                    @else
                                        <span class="badge bg-success">Cleared</span>
                                    @endif
                                </td>
                                <td>{{ $t->customer_name ?? '-' }}</td>
                                <td>{{ $t->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('transactions.destroy', $t->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this transaction?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">
                                    <div class="d-flex flex-column align-items-center mb-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No Data" width="64" class="mb-3 opacity-50">
                                        <h5 class="text-muted mb-1">No transactions found</h5>
                                        <p class="text-secondary">Start by adding a new sale to see records here.</p>
                                    </div>
                                </td>
                            </tr>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- <form action="{{ route('transactions.index') }}" method="get">
            @csrf --}}
            {{-- ✅ Summary per Item --}}
            {{-- <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Summary per Item</h5>
                        <table>
                            <tr>
                                <td>
                                    <select name="duration" id="" class="form-select">
                                        <option value="" disabled selected>-- Select Duration --</option>
                                        <option value="daily">-- Daily --</option>
                                        <option value="weekly">-- Weekly --</option>
                                        <option value="monthly">-- Monthly --</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Generate Report</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Item</th>
                                <th>Total Sold</th>
                                <th>Remaining Qty</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($itemSummaries as $index => $summary)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $summary['created_at'] }}</td>
                                    <td>{{ $summary['item_name'] }}</td>
                                    <td>{{ $summary['total_sold'] }}</td>
                                    <td>{{ $summary['remaining_qty'] }}</td>
                                    <td>
                                        @if ($summary['status'] === 'Out of Stock')
                                            <span class="badge bg-danger">{{ $summary['status'] }}</span>
                                        @elseif($summary['status'] === 'Low Stock')
                                            <span class="badge bg-warning text-dark">{{ $summary['status'] }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $summary['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No item summaries available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> --}}
        {{-- </form> --}}
    </div>
@endsection
