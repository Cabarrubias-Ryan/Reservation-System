@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="row gy-6">
  <!-- Congratulations card -->
  <div class="col-md-12 col-lg-4">
    <div class="card">
      <div class="card-body text-nowrap">
        <h5 class="card-title mb-0 flex-wrap text-nowrap">Congratulations Norris! 🎉</h5>
        <p class="mb-2">Best seller of the month</p>
        <h4 class="text-primary mb-0">$42.8k</h4>
        <p class="mb-2">78% of target 🚀</p>
        <a href="javascript:;" class="btn btn-sm btn-primary">View Sales</a>
      </div>
      <img src="{{asset('assets/img/illustrations/trophy.png')}}" class="position-absolute bottom-0 end-0 me-5 mb-5" width="83" alt="view sales">
    </div>
  </div>
  <!--/ Congratulations card -->

  <!-- Transactions -->
  <div class="col-lg-8">
    <div class="card h-100">
      <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Transactions</h5>
          <div class="dropdown">
            <button class="btn text-muted p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ri-more-2-line ri-24px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
              <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
              <a class="dropdown-item" href="javascript:void(0);">Share</a>
              <a class="dropdown-item" href="javascript:void(0);">Update</a>
            </div>
          </div>
        </div>
        <p class="small mb-0"><span class="h6 mb-0">Total 48.5% Growth</span> 😎 this month</p>
      </div>
      <div class="card-body pt-lg-10">
        <div class="row g-6">
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-primary rounded shadow-xs">
                  <i class="ri-pie-chart-2-line ri-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <p class="mb-0">Sales</p>
                <h5 class="mb-0">245k</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-success rounded shadow-xs">
                  <i class="ri-group-line ri-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <p class="mb-0">Customers</p>
                <h5 class="mb-0">12.5k</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-warning rounded shadow-xs">
                  <i class="ri-macbook-line ri-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <p class="mb-0">Product</p>
                <h5 class="mb-0">1.54k</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-info rounded shadow-xs">
                  <i class="ri-money-dollar-circle-line ri-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <p class="mb-0">Revenue</p>
                <h5 class="mb-0">$88k</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Transactions -->

  <!-- Weekly Overview Chart -->
  <div class="col-xl-4 col-md-6">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h5 class="mb-1">Weekly Overview</h5>
          <div class="dropdown">
            <button class="btn text-muted p-0" type="button" id="weeklyOverviewDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ri-more-2-line ri-24px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="weeklyOverviewDropdown">
              <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
              <a class="dropdown-item" href="javascript:void(0);">Share</a>
              <a class="dropdown-item" href="javascript:void(0);">Update</a>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body pt-lg-2">
        <div id="weeklyOverviewChart"></div>
        <div class="mt-1 mt-md-3">
          <div class="d-flex align-items-center gap-4">
            <h4 class="mb-0">45%</h4>
            <p class="mb-0">Your sales performance is 45% 😎 better compared to last month</p>
          </div>
          <div class="d-grid mt-3 mt-md-4">
            <button class="btn btn-primary" type="button">Details</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Weekly Overview Chart -->

  <!-- Total Earnings -->
  <div class="col-xl-4 col-md-6">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Total Earning</h5>
        <div class="dropdown">
          <button class="btn text-muted p-0" type="button" id="totalEarnings" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ri-more-2-line ri-24px"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalEarnings">
            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
          </div>
        </div>
      </div>
      <div class="card-body pt-lg-8">
        <div class="mb-5 mb-lg-12">
          <div class="d-flex align-items-center">
            <h3 class="mb-0">$24,895</h3>
            <span class="text-success ms-2">
              <i class="ri-arrow-up-s-line"></i>
              <span>10%</span>
            </span>
          </div>
          <p class="mb-0">Compared to $84,325 last year</p>
        </div>
        <ul class="p-0 m-0">
          <li class="d-flex mb-6">
            <div class="avatar flex-shrink-0 bg-lightest rounded me-3">
              <img src="{{asset('assets/img/icons/misc/zipcar.png')}}" alt="zipcar">
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Zipcar</h6>
                <p class="mb-0">Vuejs, React & HTML</p>
              </div>
              <div>
                <h6 class="mb-2">$24,895.65</h6>
                <div class="progress bg-label-primary" style="height: 4px;">
                  <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6">
            <div class="avatar flex-shrink-0 bg-lightest rounded me-3">
              <img src="{{asset('assets/img/icons/misc/bitbank.png')}}" alt="bitbank">
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Bitbank</h6>
                <p class="mb-0">Sketch, Figma & XD</p>
              </div>
              <div>
                <h6 class="mb-2">$8,6500.20</h6>
                <div class="progress bg-label-info" style="height: 4px;">
                  <div class="progress-bar bg-info" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="d-flex">
            <div class="avatar flex-shrink-0 bg-lightest rounded me-3">
              <img src="{{asset('assets/img/icons/misc/aviato.png')}}" alt="aviato">
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Aviato</h6>
                <p class="mb-0">HTML & Angular</p>
              </div>
              <div>
                <h6 class="mb-2">$1,2450.80</h6>
                <div class="progress bg-label-secondary" style="height: 4px;">
                  <div class="progress-bar bg-secondary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!--/ Total Earnings -->

  <!-- Four Cards -->
  <div class="col-xl-4 col-md-6">
    <div class="row gy-6">
      <!-- Total Profit line chart -->
      <div class="col-sm-6">
        <div class="card h-100">
          <div class="card-header pb-0">
            <h4 class="mb-0">$86.4k</h4>
          </div>
          <div class="card-body">
            <div id="totalProfitLineChart" class="mb-3"></div>
            <h6 class="text-center mb-0">Total Profit</h6>
          </div>
        </div>
      </div>
      <!--/ Total Profit line chart -->
      <!-- Total Profit Weekly Project -->
      <div class="col-sm-6">
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
            <h6 class="mb-1">Total Profit</h6>
            <div class="d-flex flex-wrap mb-1 align-items-center">
              <h4 class="mb-0 me-2">$25.6k</h4>
              <p class="text-success mb-0">+42%</p>
            </div>
            <small>Weekly Project</small>
          </div>
        </div>
      </div>
      <!--/ Total Profit Weekly Project -->
      <!-- New Yearly Project -->
      <div class="col-sm-6">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="avatar">
              <div class="avatar-initial bg-primary rounded-circle shadow-xs">
                <i class="ri-file-word-2-line ri-24px"></i>
              </div>
            </div>
            <div class="dropdown">
              <button class="btn text-muted p-0" type="button" id="newProjectID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ri-more-2-line ri-24px"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="newProjectID">
                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                <a class="dropdown-item" href="javascript:void(0);">Update</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <h6 class="mb-1">New Project</h6>
            <div class="d-flex flex-wrap mb-1 align-items-center">
              <h4 class="mb-0 me-2">862</h4>
              <p class="text-danger mb-0">-18%</p>
            </div>
            <small>Yearly Project</small>
          </div>
        </div>
      </div>
      <!--/ New Yearly Project -->
      <!-- Sessions chart -->
      <div class="col-sm-6">
        <div class="card h-100">
          <div class="card-header pb-0">
            <h4 class="mb-0">2,856</h4>
          </div>
          <div class="card-body">
            <div id="sessionsColumnChart" class="mb-3"></div>
            <h6 class="text-center mb-0">Sessions</h6>
          </div>
        </div>
      </div>
      <!--/ Sessions chart -->
    </div>
  </div>
  <!--/ four cards -->

  <!-- Sales by Countries -->
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
        <h6 class="mb-1">Total Earnings</h6>
        <div class="d-flex flex-wrap mb-1 align-items-center">
          <h4 class="mb-0 me-2">₱{{ number_format($amount, 2)}}</h4>
          <p class="text-success mb-0">+42%</p>
        </div>
        <div>
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
@endsection
