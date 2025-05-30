@extends('layouts/blankLayout')

@section('title', 'Home')

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('page-script')
@vite('resources/assets/js/menus.js')
@endsection

@section('content')
@include('layouts/sections/navbar/usernavbar')
<div class="container-fluid">
  <div class="position-relative">
    <div class="container p-5">

      <nav aria-label="breadcrumb" class="mt-1">
        <ol class="breadcrumb breadcrumb-style2">
          <li class="breadcrumb-item">
            <a href="{{ route('home')}}">Home</a>
          </li>
        </ol>
      </nav>
      <section class="row">
        <div class="col">
          <header class="mb-3 navbar-nav-right d-flex align-items-center px-3 mt-4">
            <div class="navbar-nav align-items-start">
              <div class="nav-item d-flex align-items-center">
                <i class="ri-search-line ri-22px me-1_5"></i>
                <div style="position: relative;">
                  <!-- Your Search Bar -->
                  <input type="search" id="search" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search..." aria-label="Search...">

                  <!-- Venue List that will be displayed below the search bar -->
                  <div id="venuelist" style="position: absolute; top: 100%; left: 0; z-index: 9999; max-height: 300px; overflow-y: auto; width: 100%; background-color: #fff; display: none; border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 0.375rem 0.375rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); margin-top: -1px;">
                    {{-- Venue list will be rendered here --}}
                  </div>
                </div>
              </div>
            </div>
            <div class="navbar-nav flex-row align-items-center ms-auto gap-5">
              <div class="navbar-nav flex-row align-items-center ms-auto gap-5">
               <div class="demo-inline-spacing">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-icon rounded dropdown-toggle hide-arrow" data-bs-toggle="modal" data-bs-target="#FilterModal"><i class="ri-filter-line"></i></button>
                </div>
              </div>
            </div>
            </div>
          </header>
          <div class="nav-align-top mb-6">
            <div class="tab-content">
              <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3">
                  @foreach($venues as $venue)
                    <div class="col mb-5">
                      <a href="{{ route('details', Crypt::encryptString($venue->id))}}" class="text-decoration-none">
                        <div class="card">
                          @php
                            $carouselId = 'carouselVenue' . $venue->id;
                          @endphp

                          <div id="{{ $carouselId }}" class="carousel carousel-dark slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                              @foreach($venue->picture as $index => $pic)
                                <button type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide-to="{{ $index }}"
                                  @if($index == 0) class="active" aria-current="true" @endif aria-label="Slide {{ $index + 1 }}"></button>
                              @endforeach
                            </div>

                            <div class="carousel-inner">
                              @foreach($venue->picture as $index => $pic)
                                <div class="carousel-item @if($index == 0) active @endif">
                                  <img class="d-block w-100" src="{{ asset($pic->path) }}" alt="Slide {{ $index + 1 }}" style="height: 300px; object-fit: cover;">
                                </div>
                              @endforeach
                            </div>

                            <a class="carousel-control-prev" href="#{{ $carouselId }}" role="button" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#{{ $carouselId }}" role="button" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </a>
                          </div>

                          <div class="card-body">
                            <h5 class="card-title">{{ $venue->name }}</h5>
                            <p><strong>₱{{ number_format($venue->price, 2) }}</strong> Per day</p>
                          </div>
                        </div>
                      </a>
                    </div>
                    @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      {{-- Filter Modal --}}
      <div class="modal fade" id="FilterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1">Filter</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="filterData" action="{{ route('home')}}" method="GET">
              <div class="row g-4">
                <label for="nameBasic mb-4">Available for reservation</label>
                <div class="col mb-4 mt-4">
                  <div class="form-floating form-floating-outline">
                    <input class="form-control" type="date" name="start" id="start-date" min="{{ date('Y-m-d') }}" />
                    <label for="checkin-date">Start Date</label>
                  </div>
                </div>
                <div class="col mb-4">
                  <div class="form-floating form-floating-outline">
                    <input class="form-control" type="date" name="end" id="end-date" min="{{ date('Y-m-d') }}" />
                    <label for="checkout-date">End Date</label>
                  </div>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col">
                  <select class="form-select" name="filter">
                    <option value="" selected>Price</option>
                    <option value="highest">Price: Highest-Lowest</option>
                    <option value="lowest">Price: Lowest-Highest</option>
                  </select>
                </div>
              </div>
               <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="sumbit" id="filterBtn" class="btn btn-primary">Filter</button>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@php
  $venues = collect($venues)->map(function($venue) {
    $prices = is_array($venue->price) ? $venue->price : [$venue->price];
    return [
      'id' => $venue->id,
      'name' => $venue->name,
      'encrypted_id' => Crypt::encryptString($venue->id),
      'min' => min($prices), // Min of prices array
      'max' => max($prices)  // Max of prices array
    ];
  })->values()->toArray();
@endphp

<script>
  window.venues = @json($venues);
</script>

@endsection
