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

      <nav aria-label="breadcrumb" class="mt-5">
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
              <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#FilterModal">
                <span class="tf-icons ri-filter-line ri-16px me-1_5"></span>Filter
              </button>
            </div>
          </header>
          <div class="nav-align-top mb-6">
            <ul class="nav nav-pills mb-4 nav-fill" role="tablist">
              <li class="nav-item mb-1 mb-sm-0">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons ri-door-line me-1_5"></i> Rooms</button>
              </li>
              <li class="nav-item mb-1 mb-sm-0">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false"><i class="tf-icons ri-drop-line me-1_5"></i> Pools</button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages" aria-selected="false"><i class="tf-icons ri-home-smile-line me-1_5"></i> House</button>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3">
                  @foreach($venues as $venue)
                    @if ($venue->category == "room")
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
                    @endif
                    @endforeach
                </div>
              </div>
              <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3">
                  @foreach($venues as $venue)
                    @if ($venue->category == "pool")
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
                    @endif
                    @endforeach
                </div>
              </div>
              <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3">
                  @foreach($venues as $venue)
                    @if ($venue->category == "house")
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
                    @endif
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
              <form id="filterData">
                @csrf
              <div class="row g-4">
                <label for="nameBasic mb-4">Available for reservation</label>
                <div class="col mb-4 mt-4">
                  <div class="form-floating form-floating-outline">
                    <input class="form-control" type="date" id="checkin-date" min="{{ date('Y-m-d') }}" />
                    <label for="checkin-date">Start Date</label>
                  </div>
                </div>
                <div class="col mb-4">
                  <div class="form-floating form-floating-outline">
                    <input class="form-control" type="date" id="checkout-date" min="{{ date('Y-m-d') }}" />
                    <label for="checkout-date">End Date</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="row">
                  <div class="col mb-6 mt-2">
                    <div class="mb-4">
                      <label for="formRange2" class="form-label">Price Range</label>
                      <input type="range" class="form-range" min="{{ $pricesRange['min'] }}" max="{{ $pricesRange['max']}}" id="formRange2">
                      <span id="rangeValue">0</span>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" id="filterBtn" class="btn btn-primary" id="FilterBtn">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@php
  $venues = collect($venues)->map(function($venue) {
    return [
      'id' => $venue->id,
      'name' => $venue->name,
      'encrypted_id' => Crypt::encryptString($venue->id),
    ];
  })->values()->toArray();
@endphp

<script>
  window.venues = @json($venues);
</script>

@endsection
