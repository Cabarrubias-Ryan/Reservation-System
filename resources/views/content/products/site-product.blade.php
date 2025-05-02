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
          <input type="text" id="search" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50 w-100" placeholder="Search..." aria-label="Search...">
        </div>
      </div>

      <!-- Buttons -->
      <div class="navbar-nav d-flex flex-row align-items-center gap-2 ms-auto">
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
          <div class="row row-cols-1 row-cols-md-3" id="rooms">

          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
          <div class="row row-cols-1 row-cols-md-3" id="pools">

          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
          <div class="row row-cols-1 row-cols-md-3" id="houses">

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
                  <option value="room">Room</option>
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
          <input type="hidden" id="Edit_id" name="id" class="form-control" placeholder="Id">
          <input type="hidden" name="removed_images[]" id="removed_images" multiple accept="image/*">
          <div class="row">
            <div class="col mb-3" id="Edit_ImagePreview" style="display: flex; flex-wrap: wrap; gap: 10px;">
              <!-- Images will appear here -->
            </div>
          </div>
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
                  <option value="room">Room</option>
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
@php
  $venues = collect($venues)->map(function($venue) {
    return [
      'id' => $venue->id,
      'name' => $venue->name,
      'category' => $venue->category,
      'description' => $venue->description,
      'picture' => $venue->picture,
      'price' => $venue->price,
      'encrypted_id' => Crypt::encryptString($venue->id),
    ];
  })->values()->toArray();
@endphp

<script>
  window.venues = @json($venues);
</script>
@endsection
