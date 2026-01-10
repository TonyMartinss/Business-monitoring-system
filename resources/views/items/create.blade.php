<!-- resources/views/about.blade.php -->
@extends('layouts.master')

@section('title', 'Create Product')

@section('page-heading', 'Register New Item')

@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-header">

            </div>

            <!-- form to create new product -->
            <form action="{{ route('items.store') }}" method="POST">
                @csrf

                <div class="card-body">
                    <!-- Product Name -->
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        placeholder="e.g. Front Brake Pads" required>

                    <!-- Quantity -->
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="0" min="0">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Unit</th>
                                <th>Content</th>
                                <th>Price</th>
                                <th>
                                    <button type="button" class="btn btn-primary btn-sm" id="add-unit-row">+ Add
                                        Unit</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="assigned-units-tbody">
                            <tr class="assigned-unit-row">
                                <td>
                                    <select name="unit[]" class="form-control" id="unit-0">
                                        <option value="">-- Select Unit --</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="content[]" id="content-0" class="form-control"
                                        placeholder="Content">
                                </td>
                                <td>
                                    <input type="number" name="price[]" id="price-0" class="form-control" step="0.01"
                                        placeholder="0.00" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Purchase Price -->
                    <label for="purchase_price">Purchase Price</label>
                    <input type="number" name="purchase_price" id="purchase_price" class="form-control" step="0.01"
                        required>

                    <!-- Category -->
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">-- {{ $category->name }} --</option>
                        @endforeach
                    </select>

                    <!-- Supplier -->
                    <label for="supplier_id">Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-control">
                        <option value="">-- Select Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">-- {{ $supplier->name }} --</option>
                        @endforeach
                    </select>

                    <!-- Reorder Level -->
                    <label for="reorder_level">Reorder Level</label>
                    <input type="number" name="reorder_level" id="reorder_level" class="form-control" value="10"
                        min="0">

                    <!-- Damaged Quantity -->
                    <label for="damaged_quantity">Damaged Quantity</label>
                    <input type="number" name="damaged_quantity" id="damaged_quantity" class="form-control" value="0"
                        min="0">

                    <!-- Barcode -->
                    <label for="barcode" class="block text-sm font-medium">Barcode</label>
                    <input type="text" name="barcode" id="barcode" class="form-control" placeholder="e.g. ABC123XYZ">

                    <!-- Expiry Date -->
                    <label for="expiry_date">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        let rowCount = 1;

        document.getElementById('add-unit-row').addEventListener('click', function() {
            const tbody = document.getElementById('assigned-units-tbody');
            const newRow = document.createElement('tr');
            newRow.className = 'assigned-unit-row';
            newRow.innerHTML = `
                <td>
                    <select name="unit[]" id="unit-${rowCount}" class="form-control" required>
                        <option value="">-- Select Unit --</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="content[]" id="content-${rowCount}" class="form-control"
                        placeholder="Content">
                </td>
                <td>
                    <input type="number" name="price[]" id="price-${rowCount}" class="form-control"
                        step="0.01" placeholder="0.00" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                </td>
            `;
            tbody.appendChild(newRow);
            rowCount++;
            attachRemoveListener(newRow.querySelector('.remove-row'));
        });

        function attachRemoveListener(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                this.closest('tr').remove();
            });
        }

        // Attach listener to initial remove button
        document.querySelectorAll('.remove-row').forEach(button => {
            attachRemoveListener(button);
        });
    </script>
@endpush
