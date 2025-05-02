@extends('layouts/contentNavbarLayout')

@section('title', 'Reservation')

@section('page-script')
  @vite('resources/assets/js/reservation.js')
@endsection

@section('content')
<div class="card">
  {{-- Search Bar --}}
  <header class="mb-3 navbar-nav-right d-flex align-items-center px-3 mt-3">
    <div class="navbar-nav align-items-start">
      <div class="nav-item d-flex align-items-center">
        <i class="ri-search-line ri-22px me-1_5"></i>
        <input type="search" id="search" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search by name or venue..." aria-label="Search...">
      </div>
    </div>
  </header>

  {{-- Reservation Table --}}
  <div class="table-responsive text-nowrap overflow-auto" style="max-height: 500px;">
    <table class="table table-hover">
      <thead class="position-sticky top-0 bg-body">
        <tr>
          <th>Name</th>
          <th>Place</th>
          <th>Check in</th>
          <th>Check out</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="reservationlist">
        {{-- JS will populate this --}}
      </tbody>
    </table>
  </div>
</div>

{{-- Pass reservations data to JS --}}
<script>
  window.reservations = @json($reservations);
</script>
@endsection
