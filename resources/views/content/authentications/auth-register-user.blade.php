@extends('layouts/blankLayout')

@section('title', 'Register')

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('page-script')
@vite('resources/assets/js/register-user.js')
@endsection


@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Register Card -->
      <div class="card p-2">
        <!-- Logo -->
        <div class="app-brand justify-content-center mt-5">
          <a href="{{url('/')}}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20])</span>
            <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
          </a>
        </div>
        <!-- /Logo -->
        <div class="card-body mt-2">
          <h4 class="mb-2">Adventure starts here 🚀</h4>
          <p class="mb-4">Make your app management easy and fun!</p>

          <form id="registerAccount">
            @csrf
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your firstname" autofocus>
              <label for="firstname">Firstname</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Enter your middlename" autofocus>
              <label for="middlename">Middlename</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your lastname" autofocus>
              <label for="lastname">Lastname</label>
            </div>
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus>
              <label for="username">Username</label>
            </div>
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
              <label for="email">Email</label>
            </div>
            <div class="mb-5 form-password-toggle">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <label for="password">Password</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
              </div>
              <div class="invalid-feedback" id="password-error" style="display: none;"></div>
            </div>
            <div class="mb-5 form-password-toggle">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="password-confirmation" class="form-control" name="password-confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <label for="password">Password Confirmation</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
              </div>
              <div class="invalid-feedback" id="password-confirmation-error" style="display: none;"></div>
            </div>

            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                <label class="form-check-label" for="terms-conditions">
                  I agree to
                  <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
              </div>
            </div>

          </form>
          <button class="btn btn-primary d-grid w-100 mb-2" id="registerAccountBtn">
            Sign up
          </button>
          <p class="text-center">
            <span>Already have an account?</span>
            <a href="{{url('login')}}">
              <span>Sign in instead</span>
            </a>
          </p>
        </div>
      </div>
      <!-- Register Card -->
      <img src="{{asset('assets/img/illustrations/tree-3.png')}}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
      <img src="{{asset('assets/img/illustrations/auth-basic-mask-light.png')}}" class="authentication-image d-none d-lg-block" alt="triangle-bg">
      <img src="{{asset('assets/img/illustrations/tree.png')}}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
    </div>
  </div>
</div>
@endsection
