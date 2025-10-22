@extends('layouts.master')

@section('title', 'Cash Movements Report')

@section('page-heading', '💵 Cash Movement History')

@section('content')

    <div class="page-content">

        <form action="{{ route('cash.report') }}" method="get">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Cash Movements Summary</h5>
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

                <!-- Movement Table -->
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-secondary">
                            <tr class="text-left text-gray-700 uppercase text-xs tracking-wider">
                                <th>#</th>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Type</th>
                                <th>Reason</th>
                                <th>Balance Before</th>
                                <th>Amount</th>
                                <th>Balance After</th>
                                <th>Performed By</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-700">
                            @forelse($movements as $index => $move)
                                <tr class="border-b hover:bg-gray-50">
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $move->created_at->format('Y-m-d H:i') }}</td>

                                    <td>{{ $move->account->name ?? 'N/A' }}</td>

                                    <td class="font-semibold">
                                        @if ($move->type === 'in')
                                            <span
                                                class="text-green-600 bg-green-100 px-2 py-1 rounded-lg text-xs font-bold">IN</span>
                                        @else
                                            <span
                                                class="text-red-600 bg-red-100 px-2 py-1 rounded-lg text-xs font-bold">OUT</span>
                                        @endif
                                    </td>

                                    <td>{{ $move->reason ?? '-' }}</td>

                                    <td>{{ number_format($move->balance_before, 2) }}</td>
                                    <td>
                                        @if ($move->type === 'in')
                                            +{{ number_format($move->amount, 2) }}
                                        @else
                                            -{{ number_format($move->amount, 2) }}
                                        @endif
                                    </td>
                                    <td>{{ number_format($move->balance_after, 2) }}</td>

                                    {{-- <td>{{ number_format($move->balance_after, 2) }}</td> --}}

                                    <td>{{ $move->user->name ?? 'System' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-gray-500">
                                        No cash movement records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-body table-responsive">
                    <!-- Movements Table -->
                    <table class="table table-striped table-bordered align-middle">
                        ...
                    </table>

                    <!-- Totals Section -->
                    <div class="mt-4">
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
                                <th>💰 Total Money:</th>
                                <td>{{ number_format(($totals['cash'] ?? 0) + ($totals['bank'] ?? 0) + ($totals['mpesa'] ?? 0), 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

            </div>
        </form>
    </div>

@endsection
@push('scripts')
    <script>
        // Any page-specific JavaScript can go here
    </script>
@endpush
