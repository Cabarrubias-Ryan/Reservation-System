@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js') <!-- Reference the new JS file here -->
@endsection

@section('content')
<div class="row gy-6">
  <!-- Total Profit line chart - Full Width -->
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h4 class="mb-0" id="totalAmountDisplay">$0.00</h4>
      </div>
      <div class="card-body">
        <div id="totalProfitLineChart" class="mb-3" style="height: 400px;"></div>
        <h6 class="text-center mb-0">Total Profit</h6>
      </div>
    </div>
  </div>
  <!--/ Total Profit line chart -->

  <!-- Sales by Countries (Sidebar) -->
  <div class="col-xl-4 col-md-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="avatar">
          <div class="avatar-initial bg-secondary rounded-circle shadow-xs">
            <i class="ri-pie-chart-2-line ri-24px"></i>
          </div>
        </div>
        <div class="dropdown">
          <button class="btn text-muted p-0" type="button" id="totalProfitID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ri-more-2-line ri-24px"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalProfitID">
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
            <a class="dropdown-item" href="javascript:void(0);">Update</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-1 mt-5">Total Earnings</h6>
        <div class="d-flex flex-wrap mb-5 align-items-center">
          <h4 class="mb-0 me-2" id="totalAmountText">₱0.00</h4>
          <p class="text-success mb-0">+42%</p>
        </div>
        <div class="mt-5">
          <ul class="p-0 m-0">
            <li class="d-flex mb-6">
            <div class="avatar flex-shrink-0 bg-lightest rounded me-3">
              <img src="{{asset('assets/img/icons/payments/stripes.png')}}" class="img-fluid" alt="stripes" height="30" width="30">
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Stripe</h6>
                <p class="mb-0">Online Reservation</p>
              </div>
              <div>
                <h6 class="mb-2">₱{{ number_format($amount, 2)}}</h6>
                <div class="progress bg-label-primary" style="height: 4px;">
                  <div class="progress-bar bg-primary" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!--/ Sales by Countries -->

  <!-- Deposit / Withdraw -->
  <div class="col-xl-8">
    <div class="card-group">
      <div class="card mb-0">
        <div class="card-body card-separator">
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h5 class="m-0 me-2">Deposit</h5>
            <a class="fw-medium" href="{{ route('admin-payment')}}">View all</a>
          </div>
          <div class="deposit-content pt-2">
            <ul class="p-0 m-0">
              @foreach ($payment as $item)
              <li class="d-flex mb-4 align-items-center pb-2">
                <div class="flex-shrink-0 me-4">
                  <img src="{{asset('assets/img/icons/payments/stripes.png')}}" class="img-fluid" alt="stripes" height="30" width="30">
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Stripe Account</h6>
                    <p class="mb-0">Bank Transfer</p>
                  </div>
                  <h6 class="text-success mb-0">+₱{{ number_format($item->amount, 2) }}</h6>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Deposit / Withdraw -->

  <!-- Data Tables -->
  <div class="col-12">
    <div class="card overflow-hidden">
      <div class="table-responsive">
        <table class="table table-sm">
          <thead>
            <tr>
              <th class="text-truncate">Name</th>
              <th class="text-truncate">Place</th>
              <th class="text-truncate">Amount</th>
              <th class="text-truncate">Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reservations as $item)
             <tr class="border-transparent">
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-4">
                    <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                  </div>
                  <div>
                    <h6 class="mb-0 text-truncate">{{ $item->firstname}}</h6>
                    <small class="text-truncate">{{ $item->email }}</small>
                  </div>
                </div>
              </td>
              <td class="text-truncate">{{  $item->venue->name }}</td>
              <td class="text-truncate">
                <div class="d-flex align-items-center">
                  <span>₱{{ number_format($item->amount, 2) }}</span>
                </div>
              </td>
              <td>
                @if ($item->status == 1)
                    <span class="badge rounded-pill bg-label-success me-1">Complete</span>
                @elseif($item->status == 0)
                    <span class="badge rounded-pill bg-label-warning me-1">Pending</span>
                @else
                    <span class="badge rounded-pill bg-label-danger me-1">Cancelled</span>
                @endif
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!--/ Data Tables -->
</div>

<!-- Pass the amounts data as a hidden JSON element -->
<span id="amounts-data" style="display:none;">{{ json_encode($amountReservation->pluck('amount')) }}</span>

@endsection
