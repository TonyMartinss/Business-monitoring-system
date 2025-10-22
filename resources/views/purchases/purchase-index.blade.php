@extends('layouts.master')

@section('title', 'Purchases')
@section('page-heading', 'Purchase Records')

@section('content')
<div class="page-content">

    {{-- ✅ Summary Section --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="p-3 bg-light rounded shadow-sm text-center">
                <h6 class="text-muted">Total Purchase Value (Tsh)</h6>
                <h4 class="fw-bold text-success">{{ number_format($totalPurchases ?? 0, 2) }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-light rounded shadow-sm text-center">
                <h6 class="text-muted">Number of Records</h6>
                <h4 class="fw-bold">{{ $purchases->count() }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-light rounded shadow-sm text-center">
                <h6 class="text-muted">Last Purchase Date</h6>
                <h4 class="fw-bold">
                    {{ $purchases->first() ? $purchases->first()->created_at->format('Y-m-d') : '-' }}
                </h4>
            </div>
        </div>
    </div>

    {{-- ✅ Purchases Table --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Purchase Records</h5>
            <a href="{{ route('purchase.create') }}" class="btn btn-primary">➕ Add Purchase</a>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>S/N</th>
                        <th>Supplier</th>
                        {{-- <th>Reference No</th> --}}
                        <th>Total Amount (Tsh)</th>
                        <th>Payment Method</th>
                        <th>Purchase Date</th>
                        {{-- <th>Notes</th> --}}
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $index => $purchase)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $purchase->supplier_name }}</td>
                            {{-- <td>{{ $purchase->reference_no }}</td> --}}
                            <td class="fw-bold text-success">{{ number_format($purchase->total_amount, 2) }}</td>
                            <td>{{ ucfirst($purchase->account->name) }}</td>
                            <td>{{ $purchase->purchase_date }}</td>
                            {{-- <td>{{ $purchase->notes ?: '-' }}</td> --}}
                            <td class="text-center">
                                <form action="{{ route('purchase.destroy', $purchase->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this purchase?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="d-flex flex-column align-items-center mb-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" 
                                         alt="No Data" width="64" class="mb-3 opacity-50">
                                    <h5 class="text-muted mb-1">No purchases recorded</h5>
                                    <p class="text-secondary">Click “Add Purchase” to start recording your purchases.</p>
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
