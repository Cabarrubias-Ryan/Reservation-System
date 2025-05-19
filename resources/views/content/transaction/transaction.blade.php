@extends('layouts/contentNavbarLayout')

@section('title', 'Payments')

@section('page-script')
  @vite('resources/assets/js/transaction.js')
@endsection

@section('content')
<div class="card">
  {{-- Search Bar --}}
  <header class="mb-3 navbar-nav-right d-flex align-items-center px-3 mt-3">
    <div class="navbar-nav align-items-start">
      <div class="nav-item d-flex align-items-center">
        <i class="ri-search-line ri-22px me-1_5"></i>
        <input type="search" id="search" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search by payment code..." aria-label="Search...">
      </div>
    </div>
  </header>

  {{-- Reservation Table --}}
  <div class="table-responsive text-nowrap overflow-auto" style="max-height: 500px;">
    <table class="table table-hover">
      <thead class="position-sticky top-0 bg-body">
        <tr>
          <th>Name</th>
          <th>Payment Code</th>
          <th>Amount</th>
          <th>Discount</th>
          <th>Voucher Code</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="transactionlist">
        {{-- JS will populate this --}}
      </tbody>
    </table>
  </div>
</div>

{{-- Pass reservations data to JS --}}
<script>
  window.payments = @json($payments);
</script>
@endsection
