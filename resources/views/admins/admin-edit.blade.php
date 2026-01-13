@extends('layouts.master')

@section('title', 'Edit User')
@section('page-heading', 'Edit User')

@section('content')
    <div class="page-content">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-semibold text-dark">Edit User</h5>
                    <span class="badge bg-primary">Admin Panel</span>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">
                        Delete
                    </button>
                </form>

                <form action="{{ route('admin.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control"
                            required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control"
                            required>
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label class="form-label">User Role</label>
                        <select name="role" class="form-control" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                                User
                            </option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                            Back
                        </a>

                        <button type="submit" class="btn btn-success">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </form>
    </div>
@endsection
