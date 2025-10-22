<!-- resources/views/about.blade.php -->
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
                <!-- table striped -->
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Price (Tsh)</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->item_code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category ?? '-' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->date_added ?? $item->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this item?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No items found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination (if you implement it later) -->
                {{-- {{ $items->links() }} --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // This is where you can add page-specific JavaScript if needed
    </script>
@endpush
