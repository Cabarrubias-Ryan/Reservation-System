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
      <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb breadcrumb-style2">
          <li class="breadcrumb-item">
            <a href="{{ route('home')}}"><i class="ri-arrow-left-s-line"></i></a>
          </li>
        </ol>
      </nav>

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
@if(session('success-payment'))
  <!-- Show Toastify message -->
  <script>
      Toastify({
          text: "{{ session('success-payment') }}",
          duration: 3000,  // Duration in milliseconds
          close: true,     // Show a close button
          gravity: "top",  // Toast will appear at the top
          position: "right",  // Position on the right
          backgroundColor: "green",  // Background color
          stopOnFocus: true
      }).showToast();
  </script>

  <!-- Hidden form that will be auto-submitted -->
  <form id="pdfForm" action="/payment/receipt" method="POST" target="_blank">
      @csrf
      <input type="hidden" name="id" id="reservation-id">
  </form>
  <script>
      $(document).ready(function () {
          const urlParams = new URLSearchParams(window.location.search);
          const id = urlParams.get('id');

          if (id) {
              $('#reservation-id').val(id);
              $('#pdfForm').submit();
              const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
              window.history.replaceState({}, "", newUrl);
          } else {
              console.log('ID not found in URL parameters');
          }
      });
  </script>
@endif
@endsection
