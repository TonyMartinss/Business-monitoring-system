@extends('layouts.master')

@section('title', 'Expense Report')

@section('page-heading', '💸 Expense History')

@section('content')

<div class="page-content">

    <form action="{{ route('expense.report') }}" method="get">
        <div class="card">

            <!-- Header: Filter & Button -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Expense Summary</h5>
                <div class="d-flex gap-2">
                    <select name="duration" class="form-select">
                        <option value="" disabled selected>-- Select Duration --</option>
                        <option value="daily">-- Daily --</option>
                        <option value="weekly">-- Weekly --</option>
                        <option value="monthly">-- Monthly --</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </div>
            </div>

            <!-- Expenses Table -->
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-secondary">
                        <tr class="text-left text-gray-700 uppercase text-xs tracking-wider">
                            <th>#</th>
                            <th>Date</th>
                            {{-- <th>Type</th> --}}
                            <th>Account</th>
                            <th>Reason</th>
                            <th>Amount</th>
                            <th>Performed By</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">
                        @forelse($expensesData as $index => $expense)
                            <tr class="border-b hover:bg-gray-50">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $expense->created_at->format('Y-m-d H:i') }}</td>
                                {{-- <td>{{ ucfirst($expense->type ?? 'N/A') }}</td> --}}
                                <td>{{ $expense->account->name ?? 'N/A' }}</td>
                                <td>{{ $expense->reason ?? '-' }}</td>
                                <td class="fw-bold">
                                    {{ number_format($expense->amount, 2) }}
                                </td>
                                <td>{{ $expense->user->name ?? 'System' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">
                                    No expense records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Totals Section -->
            <div class="card-body mt-4">
                <h5>Totals for Selected Duration:</h5>
                <table class="table table-borderless w-auto">
                    <tr>
                        <th>💵 Cash:</th>
                        <td>{{ number_format($totals['cash'] ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <th>🏦 Bank:</th>
                        <td>{{ number_format($totals['bank'] ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <th>📱 M-Pesa:</th>
                        <td>{{ number_format($totals['mpesa'] ?? 0, 2) }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <th>💰 Total Expenses:</th>
                        <td>{{ number_format(
                            ($totals['cash'] ?? 0) + 
                            ($totals['bank'] ?? 0) + 
                            ($totals['mpesa'] ?? 0), 2) 
                        }}</td>
                    </tr>
                </table>
            </div>

        </div>
    </form>

</div>

@endsection

@push('scripts')
<script>
    // Any page-specific JS can go here
</script>
@endpush
