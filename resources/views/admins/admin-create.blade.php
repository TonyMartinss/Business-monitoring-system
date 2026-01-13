@extends('layouts.master')

@section('title', 'Create User')
@section('page-heading', 'Register New User')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-header"><strong>Add New User</strong></div>
        <div class="card-body">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password" required>
                </div>

                <!-- Role Selection -->
                <div class="mb-3">
                    <label for="role">Select Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="" disabled selected>-- Select Role --</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="boss">Boss</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Add User</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Optional: You can add JS if needed (e.g., password strength)
</script>
@endpush
@endsection
