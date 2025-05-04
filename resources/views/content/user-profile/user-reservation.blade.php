@extends('layouts/blankLayout')

@section('title', 'Profile')

@section('page-script')
@vite(['resources/assets/js/pages-account-settings-account.js'])
@vite('resources/assets/js/profile-reservation.js')
@endsection

@section('content')
@include('layouts/sections/navbar/usernavbar')
<div class="container-fluid">
  <div class="position-relative">
    <div class="container p-5">
      <nav aria-label="breadcrumb" class="mt-5">
        <ol class="breadcrumb breadcrumb-style2">
          <li class="breadcrumb-item">
            <a href="{{ route('home')}}"><i class="ri-arrow-left-s-line"></i></a>
          </li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-md-12">
          <div class="nav-align-top">
            <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
              <li class="nav-item"><a class="nav-link" href="{{ route('profile')}}"><i class="ri-group-line me-1_5"></i>Account</a></li>
              <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="ri-reserved-line me-1_5"></i>Reservations</a></li>
            </ul>
          </div>
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
              <div class="table-responsive text-nowrap overflow-auto" style="max-height: 500px;">
                <table class="table table-hover">
                  <thead class="position-sticky top-0 bg-body">
                    <tr>
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
            <!-- /Account -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  window.reservations = @json($reservations);
</script>
@endsection
