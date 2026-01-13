@extends('layouts.master')

@section('title', 'Access Denied')

@section('content')
<div class="page-content d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="text-center">

        <!-- Big circle with exclamation -->
        <div class="mx-auto mb-4" style="width:120px; height:120px; border-radius:50%; background-color:#ff4d4f; display:flex; align-items:center; justify-content:center;">
            <span style="font-size:60px; color:white; font-weight:bold;">!</span>
        </div>

        <h3 class="mb-2 fw-bold">Access Denied</h3>
        <p class="mb-4 text-muted">You need admin privileges to view this page.</p>

        <a href="{{ route('transactions') }}" class="btn btn-primary btn-lg">
            Go Back Home
        </a>

    </div>
</div>
@endsection
