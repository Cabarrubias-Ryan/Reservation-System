@extends('layouts/contentNavbarLayout')

@section('title', 'Products')

@section('page-script')
@vite('resources/assets/js/product.js')
@endsection

@section('content')
<section class="row">
  <div class="col card">
    <header class="mb-3 navbar-nav-right d-flex flex-wrap align-items-center px-3 mt-4">
      <!-- Search input -->
      <div class="navbar-nav align-items-start flex-grow-1 mb-2 mb-sm-0">
        <div class="nav-item d-flex align-items-center w-100">
          <i class="ri-search-line ri-22px me-1_5"></i>
          <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50 w-100" placeholder="Search..." aria-label="Search...">
        </div>
      </div>

      <!-- Buttons -->
      <div class="navbar-nav d-flex flex-row align-items-center gap-2 ms-auto">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#FilterModal">
          <span class="tf-icons ri-filter-line ri-16px me-1_5"></span>Filter
        </button>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#AddProduct">
          <span class="tf-icons ri-add-circle-line ri-16px me-1_5"></span>Add Product
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
                    <div class="d-flex">
                      <h5 class="card-title me-auto">{{ $venue->name }}</h5>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item Edit" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditProduct"
                          ><i class="ri-pencil-line me-1"></i> Edit</a>
                          <a class="dropdown-item DeleteBtn" data-id="{{ $venue->id }}" href="javascript:void(0);"><i class="ri-delete-bin-6-line me-1"></i> Delete</a>
                        </div>
                      </div>
                    </div>
                    <p><strong>₱{{ number_format($venue->price, 2) }}</strong> Per day</p>
                  </div>
                </div>
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
                    <div class="d-flex">
                      <h5 class="card-title me-auto">{{ $venue->name }}</h5>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item Edit" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditProduct"
                          ><i class="ri-pencil-line me-1"></i> Edit</a>
                          <a class="dropdown-item DeleteBtn" data-id="{{ $venue->id }}" href="javascript:void(0);"><i class="ri-delete-bin-6-line me-1"></i> Delete</a>
                        </div>
                      </div>
                    </div>
                    <p><strong>₱{{ number_format($venue->price, 2) }}</strong> Per day</p>
                  </div>
                </div>
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
                    <div class="d-flex">
                      <h5 class="card-title me-auto">{{ $venue->name }}</h5>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item Edit" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditProduct"
                          ><i class="ri-pencil-line me-1"></i> Edit</a>
                          <a class="dropdown-item DeleteBtn" data-id="{{ $venue->id }}" href="javascript:void(0);"><i class="ri-delete-bin-6-line me-1"></i> Delete</a>
                        </div>
                      </div>
                    </div>
                    <p><strong>₱{{ number_format($venue->price, 2) }}</strong> Per day</p>
                  </div>
                </div>
              </div>
              @endif
              @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
{{-- add product modal --}}
<div class="modal fade" id="AddProduct" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProductData" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col mb-3">
              <div class="input-group">
                <input type="file" name="imagesData[]" multiple accept="image/*" class="form-control" id="DataImages">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name">
                <label for="name">Name</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="number" id="price" name="price" class="form-control" placeholder="Enter Price">
                <label for="Price">Price</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="code" name="code" class="form-control" placeholder="Enter Product Code">
                <label for="Code">Code</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-2 mt-3">
              <div class="form-floating form-floating-outline mb-6">
                <select class="form-select" id="category" name="category" aria-label="Default select example">
                  <option value="" selected>Select Category</option>
                  <option value="rooms">Rooms</option>
                  <option value="house">House</option>
                  <option value="pool">Pools</option>
                </select>
                <label for="exampleFormControlSelect1">Category</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-1 mt-1">
              <div class="form-floating form-floating-outline mb-6">
                <textarea class="form-control h-px-100" id="description" placeholder="Comments here..." name="description"></textarea>
                <label for="exampleFormControlTextarea1">Example textarea</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="SaveProduct">Save</button>
      </div>
    </div>
  </div>
</div>
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
{{-- edit product modal--}}
<div class="modal fade" id="EditProduct" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Update Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProductDataUpdate" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col mb-3">
              <div class="input-group">
                <input type="file" name="imagesData[]" multiple accept="image/*" class="form-control" id="Edit_DataImages">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="Edit_name" name="name" class="form-control" placeholder="Enter Name">
                <label for="name">Name</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="number" id="Edit_price" name="price" class="form-control" placeholder="Enter Price">
                <label for="Price">Price</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="Edit_code" name="code" class="form-control" placeholder="Enter Product Code">
                <label for="Code">Code</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-2 mt-3">
              <div class="form-floating form-floating-outline mb-6">
                <select class="form-select" id="Edit_category" name="category" aria-label="Default select example">
                  <option value="" selected>Select Category</option>
                  <option value="rooms">Rooms</option>
                  <option value="house">House</option>
                  <option value="pool">Pools</option>
                </select>
                <label for="exampleFormControlSelect1">Category</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-1 mt-1">
              <div class="form-floating form-floating-outline mb-6">
                <textarea class="form-control h-px-100" id="Edit_description" placeholder="Comments here..." name="description"></textarea>
                <label for="exampleFormControlTextarea1">Example textarea</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="UpdateProduct">Save Changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
