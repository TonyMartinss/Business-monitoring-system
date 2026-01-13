@extends('layouts.master')

@section('title', 'Edit Profile')
@section('page-heading', 'Edit Profile')


@section('content')
<div class="page-content d-flex justify-content-center align-items-start" style="min-height: 80vh; padding-top: 50px;">
    <!-- Centered Card -->
    <div class="card shadow-sm rounded-3 p-4" style="width: 500px; max-width: 95%;">
        <h4 class="mb-4 fw-bold text-center">Edit Your Profile</h4>

        <!-- Success message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Password Section -->
            <h5 class="mt-4 fw-semibold text-center">Change Password</h5>
            <p class="text-muted text-center mb-3">Leave blank if you don't want to change your password.</p>

            <!-- Current Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Current Password</label>
                <input type="password" name="current_password" class="form-control" placeholder="Enter current password">
                @error('current_password')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold">New Password</label>
                <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                @error('new_password')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Confirm New Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm new password">
            </div>

            <!-- Role (display only) -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Role</label>
                <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('profile.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>

        </form>
    </div>
</div>
@endsection
