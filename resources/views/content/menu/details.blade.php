@extends('layouts/blankLayout')

@section('title', 'Details')

@section('page-script')
@vite('resources/assets/js/menu.js')
@endsection

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('content')
<div class="container-fluid">
  <div class="position-relative">
    <div class="container p-5">
      @include('layouts/sections/navbar/usernavbar')
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
      </section>
    </div>
  </div>
</div>
@endsection
