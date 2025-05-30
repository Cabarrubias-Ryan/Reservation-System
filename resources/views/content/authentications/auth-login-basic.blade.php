@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('page-script')
@vite('resources/assets/js/login.js')
@endsection

@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6 mx-4">
      <a href="{{ route('home')}}" class="position-absolute top-0 start-0 m-3 z-1">Back</a>
      <!-- Login -->
      <div class="card p-7">
        <!-- Logo -->
        <div class="app-brand justify-content-center mt-5">
          <a href="{{url('/')}}" class="app-brand-link gap-3">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>30,"withbg"=>'fill: #fff;'])</span>
            <span class="app-brand-text demo text-heading fw-semibold">{{config('variables.templateName')}}</span>
          </a>
        </div>
        <!-- /Logo -->

        <div class="card-body mt-1">
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
      <!-- /Login -->
      <img src="{{asset('assets/img/illustrations/tree-3.png')}}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
      <img src="{{asset('assets/img/illustrations/auth-basic-mask-light.png')}}" class="authentication-image d-none d-lg-block" height="172" alt="triangle-bg">
      <img src="{{asset('assets/img/illustrations/tree.png')}}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
    </div>
  </div>
</div>
@endsection
