@extends('layouts/blankLayout')

@section('title', 'Home')

@section('page-script')
@vite('resources/assets/js/productmenu.js')
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
      <header class="border-bottom shadow-sm">
        <nav class="navbar navbar-example navbar-expand-lg bg-lightgray border-bottom-0">
          <div class="container-fluid">
            <div class="app-brand justify-content-center">
              <a href="{{url('/')}}" class="app-brand-link gap-3">
                <span class="app-brand-logo demo">@include('_partials.macros',["height"=>30])</span>
                <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
              </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-ex-4">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar-ex-4">
              <div class="navbar-nav mx-auto">
              </div>

              <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <!-- Search -->

                <!-- /Search -->
                <ul class="navbar-nav flex-row align-items-center ms-auto">

                  <!-- Place this tag where you want the button to render. -->


                  <!-- User -->
                  <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                      @guest
                      <i class="ri-account-circle-line ri-30px me-2"></i>
                      @endguest
                      @auth
                      <div class="avatar avatar-online">
                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                      @endauth
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                      @auth
                      <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-2">
                              <div class="avatar avatar-online">
                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-0 small">John Doe</h6>
                              <small class="text-muted">User</small>
                            </div>
                          </div>
                        </a>
                      </li>
                      @endauth
                      @guest
                      <li>
                        <a class="dropdown-item" href="{{ route('login')}}">
                          <i class="ri-logout-circle-r-line ri-22px me-2"></i>
                          <span class="align-middle">Login</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                          <i class="ri-user-shared-2-line ri-22px me-2"></i>
                          <span class="align-middle">Register</span>
                        </a>
                      </li>
                      @endguest
                      <li>
                        <div class="dropdown-divider"></div>
                      </li>
                      @auth
                      <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                          <i class="ri-user-3-line ri-22px me-2"></i>
                          <span class="align-middle">My Profile</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                          <i class='ri-settings-4-line ri-22px me-2'></i>
                          <span class="align-middle">Settings</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                          <span class="d-flex align-items-center align-middle">
                            <i class="flex-shrink-0 ri-file-text-line ri-22px me-3"></i>
                            <span class="flex-grow-1 align-middle">Billing</span>
                            <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger h-px-20 d-flex align-items-center justify-content-center">4</span>
                          </span>
                        </a>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                      </li>
                      <li>
                        <div class="d-grid px-4 pt-2 pb-1">
                          <a class="btn btn-danger d-flex" href="{{ route('logout-process') }}">
                            <small class="align-middle">Logout</small>
                            <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                          </a>
                        </div>
                      </li>
                      @endauth
                      @guest
                      <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                          <i class='ri-gift-line ri-22px me-2'></i>
                          <span class="align-middle">Gift card</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                          <i class='ri-question-mark ri-22px me-2'></i>
                          <span class="align-middle">Help</span>
                        </a>
                      </li>
                      @endguest
                    </ul>
                  </li>
                  <!--/ User -->
                </ul>
              </div>
            </div>
          </div>
        </nav>
      </header>
      <section class="row">
        <div class="col">
          <header class="mb-3 navbar-nav-right d-flex align-items-center px-3 mt-4">
            <div class="navbar-nav align-items-start">
              <div class="nav-item d-flex align-items-center">
                <i class="ri-search-line ri-22px me-1_5"></i>
                <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search..." aria-label="Search...">
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
                    @if ($venue->category == "rooms")
                    <div class="col mb-5">
                      <a href="" class="text-decoration-none">
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
                      <a href="" class="text-decoration-none">
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
                      <a href="" class="text-decoration-none">
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
              <div class="row">
                <div class="col mb-6 mt-2">
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name">
                    <label for="nameBasic">Name</label>
                  </div>
                </div>
              </div>
              <div class="row g-4">
                <div class="col mb-2">
                  <div class="form-floating form-floating-outline">
                    <input type="email" id="emailBasic" class="form-control" placeholder="xxxx@xxx.xx">
                    <label for="emailBasic">Email</label>
                  </div>
                </div>
                <div class="col mb-2">
                  <div class="form-floating form-floating-outline">
                    <input type="date" id="dobBasic" class="form-control">
                    <label for="dobBasic">DOB</label>
                  </div>
                </div>
              </div>
            </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="FilterBtn">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
