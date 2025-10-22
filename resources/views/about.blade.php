@extends('layouts.master')

@section('title','Sales')
@section('page-heading','Sales')

@section('content')
<div class="page-content">
  <div class="card">
    <div class="card-header">
      <a href="{{ route('sales.create') }}" class="btn btn-primary">Record Sale</a>
      <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Dashboard</a>
    </div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr><th>#</th><th>Item</th><th>Qty</th><th>Unit Price</th><th>Total</th><th>Date</th></tr>
        </thead>
        <tbody>
          @foreach($sales as $i => $sale)
            <tr>
              <td>{{ $i + 1 + (($sales->currentPage()-1) * $sales->perPage()) }}</td>
              <td>{{ $sale->product->name ?? '-' }}</td>
              <td>{{ $sale->quantity }}</td>
              <td>{{ number_format($sale->selling_price,2) }}</td>
              <td>{{ number_format($sale->total_price,2) }}</td>
              <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      {{ $sales->links() }}
    </div>
  </div>
</div>
@endsection
