@extends('layouts/contentNavbarLayout')

@section('title', 'Vouchers')

@section('page-script')
  @vite('resources/assets/js/voucher.js')
@endsection

@section('content')
<div class="card">
  {{-- Search Bar --}}
  <header class="mb-3 navbar-nav-right d-flex align-items-center px-3 mt-3">
    <div class="navbar-nav align-items-start">
      <div class="nav-item d-flex align-items-center">
        <i class="ri-search-line ri-22px me-1_5"></i>
        <input type="search" id="search" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search..." aria-label="Search...">
      </div>
    </div>
    <div class="navbar-nav flex-row align-items-center ms-auto gap-5">
      <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#AddVouchers">
        <span class="tf-icons ri-add-circle-line ri-16px me-1_5"></span>Add Vouchers
      </button>
    </div>
  </header>

  {{-- Reservation Table --}}
  <div class="table-responsive text-nowrap overflow-auto" style="max-height: 500px;">
    <table class="table table-hover">
      <thead class="position-sticky top-0 bg-body">
        <tr>
          <th>Name</th>
          <th>Code</th>
          <th>Discount</th>
          <th>Date Created</th>
          <th>Expire Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="voucherlist">
        {{-- JS will populate this --}}
      </tbody>
    </table>
  </div>
</div>
<div class="modal fade" id="AddVouchers" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Vouchers</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="VoucherData" class="modal-body">
        @csrf
        <div class="row">
          <!-- Name Field -->
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="text" id="voucherName" name="voucherName" class="form-control" placeholder="Enter Voucher Name">
              <label for="voucherName">Voucher Name</label>
            </div>
          </div>
        </div>
        <!-- Code Field -->
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="text" id="voucherCode" name="voucherCode" class="form-control" placeholder="Enter Code">
              <label for="voucherCode">Voucer Code</label>
            </div>
          </div>
        </div>
          <!-- Requirements Field -->
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="number" id="voucherRequirements" name="voucherRequirements" class="form-control" placeholder="Enter Minimum purchase">
              <label for="voucherRequirements">Requirements</label>
            </div>
          </div>
        </div>

          <!-- Discount Field -->
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="number" id="voucherDiscount" name="voucherDiscount" class="form-control" placeholder="Enter Discount Percentage">
              <label for="voucherDiscount">Discount (%)</label>
            </div>
          </div>
        </div>
        <!-- Date Field -->
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="date" id="voucherExpire" name="voucherExpire" class="form-control" placeholder="Enter Expire Date">
              <label for="voucherExpire">Expire Date</label>
            </div>
          </div>
        </div>
        <!-- Description Field -->
      <div class="row">
        <div class="col mb-6 mt-2">
          <div class="form-floating form-floating-outline">
            <textarea id="voucherDescription" name="voucherDescription" class="form-control h-px-120" placeholder="Enter Description" rows="4"></textarea>
            <label for="voucherDescription">Description</label>
          </div>
        </div>
      </div>

      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="BtnVoucher">Save changes</button>
      </div>
    </div>
  </div>
</div>
{{-- Edit Modal --}}
<div class="modal fade" id="EditVoucher" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Vouchers</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="Edit_VoucherData" class="modal-body">
        @csrf
        <input type="hidden" id="Edit_id" name="id" class="form-control" placeholder="Enter Voucher Name">
        <div class="row">
          <!-- Name Field -->
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="text" id="Edit_voucherName" name="voucherName" class="form-control" placeholder="Enter Voucher Name">
              <label for="voucherName">Voucher Name</label>
            </div>
          </div>
        </div>
        <!-- Code Field -->
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="text" id="Edit_voucherCode" name="voucherCode" class="form-control" placeholder="Enter Code">
              <label for="voucherCode">Voucer Code</label>
            </div>
          </div>
        </div>
          <!-- Requirements Field -->
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="number" id="Edit_voucherRequirements" name="voucherRequirements" class="form-control" placeholder="Enter Minimum purchase">
              <label for="voucherRequirements">Requirements</label>
            </div>
          </div>
        </div>

          <!-- Discount Field -->
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="number" id="Edit_voucherDiscount" name="voucherDiscount" class="form-control" placeholder="Enter Discount Percentage">
              <label for="voucherDiscount">Discount (%)</label>
            </div>
          </div>
        </div>
        <!-- Date Field -->
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="date" id="Edit_voucherExpire" name="voucherExpire" class="form-control" placeholder="Enter Expire Date">
              <label for="voucherExpire">Expire Date</label>
            </div>
          </div>
        </div>
        <!-- Description Field -->
      <div class="row">
        <div class="col mb-6 mt-2">
          <div class="form-floating form-floating-outline">
            <textarea id="Edit_voucherDescription" name="voucherDescription" class="form-control h-px-120" placeholder="Enter Description" rows="4"></textarea>
            <label for="voucherDescription">Description</label>
          </div>
        </div>
      </div>

      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="BtnEditVouchers">Save changes</button>
      </div>
    </div>
  </div>
</div>

@php
  $voucher = collect($voucher)->map(function($voucher) {
  return [
      'id' => $voucher->id,
      'encrypted_id' => Crypt::encryptString($voucher->id),
      'code' => $voucher->code,
      'name' => $voucher->name,
      'discount' => $voucher->discount,
      'use' => $voucher->use,
      'date' => $voucher->created_at,
      'expire_date' => $voucher->expire_date,
      'description' => $voucher->description,
      'requirements' => $voucher->requirements
  ];
  })->values()->toArray();
@endphp
<script>
  window.voucher = @json($voucher);
</script>
@endsection
