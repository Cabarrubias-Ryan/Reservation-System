@extends('layouts/blankLayout')

@section('title', 'Vouchers')

@section('page-script')
@vite(['resources/assets/js/pages-account-settings-account.js'])
@endsection

@section('content')
@include('layouts/sections/navbar/usernavbar')
<div class="container-fluid">
  <div class="position-relative">
    <div class="container p-5">
      <nav aria-label="breadcrumb" class="mt-5">
        <ol class="breadcrumb breadcrumb-style2">
          <li class="breadcrumb-item">
            <a href="{{ route('home')}}"><i class="ri-arrow-left-s-line"></i></a>
          </li>
        </ol>
      </nav>

      <div class="row">
        <div class="nav-align-top">
          <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
            <li class="nav-item"><a class="nav-link" href="{{ route('vouchers-list') }}"><i class="ri-coupon-line me-1_5"></i> Vouchers List</a></li>
            <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="ri-coupon-3-line me-1_5"></i> My Vouchers</a></li>
          </ul>
        </div>
        <div>
          <div class="row row-cols-1 row-cols-md-3">

            @foreach ($voucher as $item)
              <div class="col">
                <div class="card h-100 text-center border-success">
                  <div class="card-body d-flex flex-column justify-content-between">
                    @csrf
                    <input type="hidden" value="{{ Crypt::encryptString($item->id)}}" name="id">
                    <div>
                      <h5 class="card-title text-success">{{ $item->name }}</h5>
                      <p class="card-text mb-1">{{ $item->description }}.</p>
                      <p class="text-muted small mb-3">Min. Spend: RM {{ number_format($item->requirements, 2) }}</p>
                      <h4 class="text-danger">{{ $item->discount }}% OFF</h4>
                    </div>
                     @if ($item->is_expired)
                          <button class="btn btn-secondary mt-3" style="width: 150px; margin: 0 auto;" disabled>Expired</button>
                      @elseif ($item->used == 0)
                          <button class="btn btn-primary mt-3" style="width: 150px; margin: 0 auto;">Claimed</button>
                      @else
                          <button class="btn btn-gray mt-3" style="width: 150px; margin: 0 auto;" disabled>Used</button>
                      @endif
                  </div>
                </div>
              </div>
            @endforeach

          </div>
          <div class="row">
            @if (empty($item))
                <div class="col">
                  <p class="text-center">No Available voucher</p>
                </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
