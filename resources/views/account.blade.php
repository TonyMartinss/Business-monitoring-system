@extends('layouts.master')

@section('title', 'Manage Accounts')
@section('page-heading', 'Accounts Management')

@section('content')
<div class="page-content">

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Create New Account Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">➕ Register New Account</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="name">Account Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="type">Account Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="">-- Select Type --</option>
                            <option value="savings">Savings</option>
                            <option value="current">Current</option>
                            <option value="business">Business</option>
                            <option value="loan">Loan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="number">Account Number</label>
                        <input type="text" name="number" id="number" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="balance">Opening Balance</label>
                        <input type="number" step="0.01" name="balance" id="balance" class="form-control" value="0.00">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Save Account</button>
            </form>
        </div>
    </div>

    <!-- Accounts List -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">📋 Accounts List</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Number</th>
                        <th>Balance (Tsh)</th>
                        <th>Created At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $index => $account)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $account->name }}</td>
                            <td>{{ ucfirst($account->type) }}</td>
                            <td>{{ $account->number }}</td>
                            <td class="fw-bold {{ $account->balance < 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($account->balance, 2) }}
                            </td>
                            <td>{{ $account->created_at->format('Y-m-d') }}</td>
                            <td class="text-center">
                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $account->id }}">
                                    ✏️ Edit
                                </button>

                                <!-- Delete Form -->
                                <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this account?')" class="btn btn-sm btn-danger">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $account->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title">Edit Account: {{ $account->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('accounts.update', $account->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="name">Account Name</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $account->name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="type">Account Type</label>
                                                    <select name="type" class="form-control" required>
                                                        <option value="savings" {{ $account->type == 'savings' ? 'selected' : '' }}>Savings</option>
                                                        <option value="current" {{ $account->type == 'current' ? 'selected' : '' }}>Current</option>
                                                        <option value="business" {{ $account->type == 'business' ? 'selected' : '' }}>Business</option>
                                                        <option value="loan" {{ $account->type == 'loan' ? 'selected' : '' }}>Loan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="number">Account Number</label>
                                                    <input type="text" name="number" class="form-control" value="{{ $account->number }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="balance">Balance</label>
                                                    <input type="number" step="0.01" name="balance" class="form-control" value="{{ $account->balance }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Update Account</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No accounts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
