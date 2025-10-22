<!-- resources/views/items/product-index.blade.php -->
@extends('layouts.master')

@section('title', 'Product')

@section('page-heading', 'Motorcycle Spare Parts')

@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('items.create') }}" class="btn btn-primary">Add New Item</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                {{-- <th>Barcode</th> --}}
                                <th>Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Purchase Price (Tsh)</th>
                                <th>Selling Price (Tsh)</th> <!-- ✅ Added Column -->
                                <th>Total Price (Tsh)</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    {{-- <td>{{ $item->barcode ?? '-' }}</td> --}}
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category->name ?? '-' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->purchase_price, 2) }}</td>
                                    <td>{{ number_format($item->selling_price, 2) }}</td> <!-- ✅ Added Data -->
                                    <td>{{ number_format($item->quantity * $item->purchase_price, 2) }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this item?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No items found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <strong>Grand Total (All Items):</strong>
                    {{ number_format($items->sum(fn($i) => $i->quantity * $i->purchase_price), 2) }} Tsh
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Page-specific JS if needed
    </script>
@endpush
