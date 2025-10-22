@extends('layouts.master')

@section('title', 'Admin Panel')
@section('page-heading', 'Admin Sales Overview')

@section('content')
<div class="page-content">
    <div class="row">
        <!-- Daily Sales -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Daily Sales</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($dailySales, 2) }} Tsh</h5>
                </div>
            </div>
        </div>

        <!-- Weekly Sales -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Weekly Sales</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($weeklySales, 2) }} Tsh</h5>
                </div>
            </div>
        </div>

        <!-- Monthly Sales -->
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Monthly Sales</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($monthlySales, 2) }} Tsh</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue, Cost, Profit/Loss -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-primary mb-3">
                <div class="card-header">Total Revenue</div>
                <div class="card-body text-primary">
                    <h5 class="card-title">{{ number_format($totalRevenue, 2) }} Tsh</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger mb-3">
                <div class="card-header">Total Cost</div>
                <div class="card-body text-danger">
                    <h5 class="card-title">{{ number_format($totalCost, 2) }} Tsh</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success mb-3">
                <div class="card-header">Profit / Loss</div>
                <div class="card-body text-success">
                    <h5 class="card-title">{{ number_format($profitOrLoss, 2) }} Tsh</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
