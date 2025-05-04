@extends('layouts/blankLayout')

@section('title', 'Details')

@section('page-script')
@vite('resources/assets/js/details.js')
@endsection

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('content')
@include('layouts/sections/navbar/usernavbar')
<div class="container-fluid">
  <div class="position-relative">
    <div class="container p-5">
      <nav aria-label="breadcrumb" class="mt-5">
        <ol class="breadcrumb breadcrumb-style2">
          <li class="breadcrumb-item">
            <a href="{{ route('home')}}">Home</a>
          </li>
          <li class="breadcrumb-item active">Details</li>
        </ol>
      </nav>
      <section class="mt-5">
        <h3 class="my-3 font-bolder">{{$venue->name}}</h3>
        <div class="row g-0">
          @foreach($venue->picture->take(5) as $index => $pic)
              @if($index == 0)
                  <!-- First image: 60% -->
                  <div class="col-12 col-md-7">
                      <img src="{{ asset($pic->path) }}" alt="Featured Picture" class="img-fluid rounded" style="height: 100%; width: 100%; object-fit: cover;">
                  </div>
                  <!-- Container for the remaining images -->
                  <div class="col-12 col-md-5 d-flex flex-wrap">
              @else
                  @php
                      $remaining = min(4, $venue->picture->count() - 1);
                      $widthClass = 'w-100'; // default if only 1 extra image
                      if ($remaining > 1) {
                          $widthClass = 'w-50'; // two columns if more than 1 remaining
                      }
                  @endphp
                  <div class="{{ $widthClass }} p-1" style="height: {{ 100 / ceil($remaining / 2) }}%;">
                      <img src="{{ asset($pic->path) }}" alt="Gallery Picture" class="img-fluid rounded" style="height: 100%; width: 100%; object-fit: cover;">
                  </div>
              @endif
          @endforeach

            @if($venue->picture->count() > 0)
                </div> <!-- Close remaining images container -->
            @endif
        </div>

        <p class="mb-5 mt-5">{{$venue->description}}</p>
        <h4 class="mb-3 font-bolder">What this place can offer</h4>
        <div class="row justify-content-between mt-5">
          <!-- Left side: Badges -->
          <div class="col-md-6 col-lg-5">
            <div class="mb-5 d-flex flex-wrap gap-2">
              <span class="badge bg-label-primary">Free Wi-Fi</span>
              <span class="badge bg-label-primary">Free Parking</span>
              <span class="badge bg-label-primary">Swimming Pool</span>
              <span class="badge bg-label-primary">Gym</span>
            </div>
          </div>

          <!-- Right side: Price and form -->
          <div class="col-md-6 col-lg-5">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><span class="fw-bold" >₱{{ number_format($venue->price, 2) }}</span> per day</h5>
                <div class="d-flex my-4 align-items-center gap-5">
                  <div class="row w-100">
                    <form id="reservation-form">
                      <input type="hidden" id="venue_id" value="{{$venue->id}}">
                      <input type="hidden" id="venue_name" value="{{$venue->name}}">
                      <input type="hidden" id="venue_price" value="{{$venue->price}}">
                    <div class="col mb-4">
                      <div class="form-floating form-floating-outline">
                        <input class="form-control" type="date" id="checkin-date" min="{{ date('Y-m-d') }}" />
                        <label for="checkin-date">CHECK-IN</label>
                      </div>
                    </div>
                    <div class="col mb-4">
                      <div class="form-floating form-floating-outline">
                        <input class="form-control" type="date" id="checkout-date" min="{{ date('Y-m-d') }}" />
                        <label for="checkout-date">CHECK-OUT</label>
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
                <button class="btn btn-primary w-100" {{ Auth::check() ? 'id=reservationBtn' : 'data-bs-toggle=modal data-bs-target=#loginModal' }} ">Reserve</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="mt-5">
        <h4 class="my-5">Calendar</h4>
        <div class="card p-5">
          <div id='calendar'></div>
        </div>
      </section>
    </div>
  </div>
</div>
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

          <!-- Logo -->
          <div class="app-brand justify-content-center mt-5">
            <a href="{{url('/')}}" class="app-brand-link gap-3">
              <span class="app-brand-logo demo">@include('_partials.macros',["height"=>30,"withbg"=>'fill: #fff;'])</span>
              <span class="app-brand-text demo text-heading fw-semibold">{{config('variables.templateName')}}</span>
            </a>
          </div>
          <!-- /Logo -->

          <div class="card-body mt-1 px-5">
            <h4 class="mb-1">Welcome to {{config('variables.templateName')}}! 👋🏻</h4>
            <p class="mb-5">Please sign-in to your account and start the adventure</p>

            <form id="formAuthentication" class="mb-5">
              @csrf
              <div class="form-floating form-floating-outline mb-5">
                <input type="text" class="form-control" id="email" name="email_username" placeholder="Enter your email or username" autofocus>
                <label for="email">Email or Username</label>
              </div>
              <div class="mb-5">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                      <label for="password">Password</label>
                    </div>
                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
                  </div>
                </div>
              </div>
              <div class="mb-5 pb-2 d-flex justify-content-between pt-2 align-items-center">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="remember-me">
                  <label class="form-check-label" for="remember-me">
                    Remember Me
                  </label>
                </div>
                <a href="{{url('auth/forgot-password-basic')}}" class="float-end mb-1">
                  <span>Forgot Password?</span>
                </a>
              </div>

            </form>
            <div class="mb-5">
              <button class="btn btn-primary d-grid w-100" type="submit" id="loginBtn">login</button>
            </div>
            <p class="text-center">
              <span>New on our platform?</span>
              <a href="{{url('auth/register-user')}}">
                <span>Create an account</span>
              </a>
            </p>
            <div class="text-center mt-3">
              <span>Or Sign with</span>
            </div>
            <div class="d-flex justify-content-center mt-3 gap-3">
                <a href="{{ route('auth.provider.redirect','google') }}" class="btn btn-primary border rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                  <i class="ri-google-line"></i>
                </a>
                <a href="{{ route('auth.provider.redirect','facebook') }}" class="btn btn-danger border rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                  <i class="ri-facebook-fill"></i>
                </a>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
@if (Auth::check())
<div class="modal fade" id="Details" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Reservation Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="detailData">
          @csrf
          <div style="display:none;" id="VenueId"></div>
          <div class="row mb-3">
            <div class="col">
              <div class="fw-bold">Name: <span>{{ Auth::user()->firstname}} {{ Auth::user()->middlename == null ? ' ' : Auth::user()->middlename}} {{ Auth::user()->lastname}}</span></div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-4 fw-bold">Place:</div>
            <div class="col-8" id="name"></div>
          </div>
          <div class="row mb-2">
            <div class="col-4 fw-bold">Time:</div>
            <div class="col-8">
              <span id="checkin"></span> - <span id="checkout"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-4 fw-bold">Price:</div>
            <div class="col-8" id="price"></div>
          </div>

          <div class="row mb-2">
            <div class="col-4 fw-bold">Number of Days:</div>
            <div class="col-8" id="dayDifference"> days</div>
          </div>

          <div class="row mb-2">
            <div class="col-4 fw-bold">Total Price:</div>
            <div class="col-8" id="totalPrice"></div>
          </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="reservationProcessBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="paymentOptions" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Payment Options</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info" role="alert">
          <i class="ri-information-line me-2"></i> You can choose to pay now or later. If you choose to pay later, please remember to make the payment within 2 days to confirm your reservation. The first to pay will be the first to reserve the other will be cancel.
        </div>
        <h6>Would you like to make a payment now or later?</h6>
        <div class="d-flex justify-content-center">
          <button type="button" class="btn btn-primary me-2" id="payNowBtn">
            <i class="ri-bank-card-line me-2"></i> Pay Now
          </button>
          <button type="button" class="btn btn-secondary" id="payLaterBtn" data-bs-dismiss="modal" aria-label="Close">
            <i class="ri-time-line me-2"></i> Pay Later
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
<script>
  window.reservations = @json($reservations);
 </script>
@endsection
