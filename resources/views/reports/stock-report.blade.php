@extends('layouts.master')

@section('title', 'Stock Movements Report')

@section('page-heading', '📦 Stock Movement History')

@section('content')

    <div class="page-content">

        <form action="{{ route('stock.report') }}" method="get">
            <div class="card">
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

                <!-- Movement Table -->
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-secondary">
                            <tr class="bg-gray-100 text-left text-gray-700 uppercase text-xs tracking-wider">
                                <th>#</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Before QTy</th>
                                <th>Type</th>
                                 <th>Reason</th>
                                <th>Quantity</th>
                                <th>After QTy</th>
                                <th>Performed By</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-700">
                            @forelse($movements as $index => $move)
                                <tr class="border-b hover:bg-gray-50">
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $move->created_at->format('Y-m-d H:i') }}</td>

                                    <td>{{ $move->product->name ?? 'N/A' }}</td>

                                    <td class="px-4 py-2">{{ $move->balance_before }}</td>

                                    <td class="px-4 py-2 font-semibold">
                                        @if ($move->type === 'in')
                                            <span
                                                class="text-green-600 bg-green-100 px-2 py-1 rounded-lg text-xs font-bold">IN</span>
                                        @else
                                            <span
                                                class="text-red-600 bg-red-100 px-2 py-1 rounded-lg text-xs font-bold">OUT</span>
                                        @endif
                                    </td>
                                    <td>{{ $move->reason ?? '-' }}</td>
                                    <td>
                                        @if ($move->type === 'in')
                                            + {{ $move->quantity }}
                                        @else
                                            - {{ $move->quantity }}
                                        @endif
                                    </td>
                                    <td>{{ $move->balance_after }}</td>

                                    <td>{{ $move->user->name ?? ($move->user_id ?? 'System') }}</td>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-6 text-gray-500">
                                        No stock movement records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    @endsection
