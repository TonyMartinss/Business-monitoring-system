@extends('layouts.master')

@section('title', 'Create Transaction')
@section('page-heading', 'Register New Transaction')

@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-header"><strong>Add New Transaction</strong></div>
            <div class="card-body">
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    <div class="container-fluid">
                        <div class="row">
                            <!-- LEFT COLUMN: Products Table -->
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <table class="table table-bordered" id="productsTable">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th width="150">Price</th>
                                                <th width="120">Qty</th>
                                                <th width="120">Amount</th>
                                                <th width="120">Disc</th>
                                                <th width="50"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="product_id[]" class="form-control id" id="product_id-0"
                                                        required>
                                                        <option value="">-- Select Product --</option>
                                                        @foreach ($items as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name }} (Stock: {{ $item->quantity }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="text" name="price[]" class="form-control price"
                                                        id="price-0" min="0" required>
                                                </td>

                                                <td>
                                                    <input type="number" name="qty[]" id="quantity-0"
                                                        class="form-control qty" min="1" value="1" required>
                                                </td>

                                                <td>
                                                    <input type="text" name="amount[]" id="amount-0"
                                                        class="form-control amount" min="1" value="0" readonly>
                                                </td>

                                                <td>
                                                    <input type="number" name="disc[]" id="disc-0"
                                                        class="form-control disc" min="1" value="0" required>
                                                </td>

                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-row">×</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <button type="button" class="btn btn-primary btn-sm" id="addRow">
                                        + Add Product
                                    </button>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN: Sales Summary -->
                            <div class="col-md-3">

                                <!-- Total -->
                                <div class="d-flex mb-2 align-items-center">
                                    <span class="me-2" style="width: 80px;">Total:</span>
                                    <input type="text" name="total" class="form-control flex-grow-1" readonly>
                                </div>

                                <!-- Discount -->
                                <div class="d-flex mb-2 align-items-center">
                                    <span class="me-2" style="width: 80px;">Discount:</span>
                                    <input type="text" name="discount" class="form-control flex-grow-1">
                                </div>

                                <!-- Net Amount -->
                                <div class="d-flex mb-2 align-items-center">
                                    <span class="me-2" style="width: 80px;">Net:</span>
                                    <input type="text" name="net_amount" class="form-control flex-grow-1" readonly>
                                </div>

                                <!-- Paid Amount -->
                                <div class="d-flex mb-2 align-items-center">
                                    <span class="me-2" style="width: 80px;">Paid:</span>
                                    <input type="text" name="paid_amount" class="form-control flex-grow-1">
                                </div>

                                <!-- Due Amount -->
                                <div class="d-flex mb-2 align-items-center">
                                    <span class="me-2" style="width: 80px;">Due:</span>
                                    <input type="text" name="due_amount" class="form-control flex-grow-1" readonly>
                                </div>

                                <!-- Account -->
                                <div class="d-flex mb-2 align-items-center">
                                    <span class="me-2" style="width: 80px;">Account:</span>
                                    <select name="account_id" class="form-control flex-grow-1" required>
                                        <option disabled selected value="">-- Select Account --</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Customer Name -->
                                <div class="d-flex mb-2 align-items-center">
                                    <span class="me-2" style="width: 80px;">Customer:</span>
                                    <select id="customerSelect" name="customer_id" class="form-control flex-grow-1"
                                        required>
                                        <option disabled selected value="">-- Select Customer --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Customer Phone -->
                                <div class="d-flex mb-2 align-items-center">
                                    <span class="me-2" style="width: 80px;">Phone:</span>
                                    <input type="text" id="customerPhone" name="customer_phone"
                                        class="form-control flex-grow-1" placeholder="Enter phone">
                                </div>

                                <!-- Customer Address -->
                                <div class="d-flex mb-2 align-items-center">
                                    <span class="me-2" style="width: 80px;">Address:</span>
                                    <input type="text" id="customerAddress" name="customer_address"
                                        class="form-control flex-grow-1" placeholder="Enter address">
                                </div>

                                <!-- Buttons -->
                                <button type="submit" class="btn btn-success btn-block mt-2">Confirm</button>
                                <a href="{{ route('transactions.index') }}"
                                    class="btn btn-danger btn-block mt-1">Cancel</a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let rowIndex = 1;

            // Add new product row
            document.getElementById('addRow').addEventListener('click', function() {
                const tbody = document.querySelector('#productsTable tbody');

                const row = `
        <tr>
            <td>
                <select name="product_id[]" class="form-control id" id="product_id-${rowIndex}" required>
                    <option value="">-- Select Product --</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" data-price="{{ $item->selling_price }}">
                            {{ $item->name }} (Stock: {{ $item->quantity }})
                        </option>
                    @endforeach
                </select>
            </td>

            <td>
                <input type="number" name="price[]" class="form-control price" id="price-${rowIndex}" min="0" step="0.01" required>
            </td>

            <td>
                <input type="number" name="qty[]" class="form-control qty" id="quantity-${rowIndex}" min="1" value="1" required>
            </td>

            <td>
                <input type="text" name="amount[]" class="form-control amount" id="amount-${rowIndex}" value="0" readonly>
            </td>

            <td>
                <input type="number" name="disc[]" class="form-control disc" id="disc-${rowIndex}" value="0" required>
            </td>

            <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">×</button>
            </td>
        </tr>
    `;

                tbody.insertAdjacentHTML('beforeend', row);
                rowIndex++;
            });

            // Remove row
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                    updateVerticalSummary();
                }
            });

            // Function to calculate a single row amount
            function calculateRowAmount(row) {
                const price = parseFloat(row.querySelector('.price').value) || 0;
                const qty = parseFloat(row.querySelector('.qty').value) || 0;
                const disc = parseFloat(row.querySelector('.disc').value) || 0;
                const amount = (price * qty) - disc;
                row.querySelector('.amount').value = amount.toFixed(2);
                return amount;
            }

            // Function to update right column summary
            function updateVerticalSummary() {
                let total = 0;

                document.querySelectorAll('#productsTable tbody tr').forEach(row => {
                    total += calculateRowAmount(row);
                });

                const totalInput = document.querySelector('input[name="total"]');
                totalInput.value = total.toFixed(2);

                const discount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
                const net = total - discount;
                document.querySelector('input[name="net_amount"]').value = net.toFixed(2);

                const paid = parseFloat(document.querySelector('input[name="paid_amount"]').value) || 0;
                const due = net - paid;
                document.querySelector('input[name="due_amount"]').value = due.toFixed(2);
            }

            // Listen for changes in all relevant inputs (qty, price, disc, discount, paid_amount)
            document.addEventListener('input', function(e) {
                if (
                    e.target.classList.contains('qty') ||
                    e.target.classList.contains('price') ||
                    e.target.classList.contains('disc') ||
                    e.target.name === 'discount' ||
                    e.target.name === 'paid_amount'
                ) {
                    updateVerticalSummary();
                }
            });

            // Optional: Auto-fill price when product selected
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('id')) {
                    const row = e.target.closest('tr');
                    const priceInput = row.querySelector('.price');
                    const selectedOption = e.target.selectedOptions[0];
                    const productPrice = parseFloat(selectedOption.dataset.price) || 0;
                    priceInput.value = productPrice.toFixed(2);
                    updateVerticalSummary();
                }
            });

            // Fetch customer details on selection
            document.getElementById('customerSelect').addEventListener('change', function() {
                const customerId = this.value;

                if (customerId) {
                    fetch('/customers/' + customerId)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            document.getElementById('customerPhone').value = data.phone || '';
                            document.getElementById('customerAddress').value = data.address || '';
                        })
                        .catch(() => {
                            alert('Unable to fetch customer details.');
                            document.getElementById('customerPhone').value = '';
                            document.getElementById('customerAddress').value = '';
                        });
                } else {
                    document.getElementById('customerPhone').value = '';
                    document.getElementById('customerAddress').value = '';
                }
            });
        </script>
    @endpush

@endsection
