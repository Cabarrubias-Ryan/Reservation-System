@extends('layouts/blankLayout')

@section('title', 'Payment Reservation')

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('page-script')
@vite('resources/assets/js/payment.js')
@endsection

@section('content')
@include('layouts/sections/navbar/usernavbar')

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
      <div class="card shadow rounded p-4">
        <div class="mb-3">
          <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
            ← Home
          </a>
        </div>

        <h4 class="text-center mb-4">Payment Reservation</h4>

        <form method="POST" action="{{ route('payment-add') }}">
          @csrf
          <div style="display:none;" id="VenueId"></div>

          <div class="mb-4">
            <div class="fw-bold">Name:
              <span>{{ Auth::user()->firstname }}
                {{ Auth::user()->middlename ?? '' }}
                {{ Auth::user()->lastname }}
              </span>
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-4 fw-bold">Place:</label>
            <div class="col-sm-8" id="name"></div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-4 fw-bold">Time:</label>
            <div class="col-sm-8">
              <span id="checkin"></span> - <span id="checkout"></span>
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-4 fw-bold">Price:</label>
            <div class="col-sm-8" id="price"></div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-4 fw-bold">Number of Days:</label>
            <div class="col-sm-8" id="dayDifference"> days</div>
          </div>

          <div class="mb-4 row">
            <label class="col-sm-4 fw-bold">Total Price:</label>
            <div class="col-sm-8" id="totalPrice"></div>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  window.reservation = @json($reservation);
</script>
@endsection
