@extends('layouts/contentNavbarLayout')

@section('title', 'Reports Reservation')

@section('page-script')
  @vite('resources/assets/js/reservationReports.js')
@endsection

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card mb-6">
      <!-- Account -->
      <div class="card-body pt-5">
        <header class="mb-3 navbar-nav-right d-flex align-items-center px-3 mt-3">
          <div class="navbar-nav align-items-start">
            <div class="nav-item d-flex align-items-center">
              <i class="ri-search-line ri-22px me-1_5"></i>
              <input type="search" id="search" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search by name or venue..." aria-label="Search...">
            </div>
          </div>
        </header>
        <div class="table-responsive text-nowrap overflow-auto" style="max-height: 425px;">
          <table class="table table-hover">
            <thead class="position-sticky top-0 bg-body">
              <tr>
                <th>Name</th>
                <th>Place</th>
                <th>Check in</th>
                <th>Check out</th>
                <th>Amount</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="reservationlist">
              {{-- JS will populate this --}}
            </tbody>
          </table>
        </div>
      </div>
      <!-- /Account -->
    </div>
  </div>
</div>
<script>
  window.reservations = @json($reservations);
</script>
@endsection
