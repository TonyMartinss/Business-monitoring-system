@extends('layouts.master')

@section('title', 'My Profile')
@section('page-heading', 'My Profile')

@section('content')
    <div class="page-content">
        <div class="card shadow-sm rounded-3 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">My Profile</h4>

            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold"><strong>Full Name</strong></label>
                    <p class="form-control-plaintext">{{ $user->name }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold"><strong>Email Address</strong></label>
                    <p class="form-control-plaintext">{{ $user->email }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold"><strong>Role</strong></label>
                    <p class="form-control-plaintext">{{ ucfirst($user->role) }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold"><strong>Last Login</strong></label>
                    <p class="form-control-plaintext">
                        {{ $user->last_login_at ?? 'Never' }}
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
@endsection
