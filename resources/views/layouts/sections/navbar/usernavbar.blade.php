<header class="border-bottom shadow-sm">
  <nav class="navbar navbar-example navbar-expand-lg bg-lightgray border-bottom-0">
    <div class="container py-2">
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
                  <a class="dropdown-item" href="{{ route('profile')}}">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0 me-2">
                        <div class="avatar avatar-online">
                          <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-0 small">
                          {{ Auth::user()->firstname }}
                          {{ Auth::user()->middlename ?? '' }}
                          {{ Auth::user()->lastname }}
                        </h6>
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
                  <a class="dropdown-item" href="{{ route('auth-register-user')}}">
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
                  <a class="dropdown-item" href="{{route('profile-reservation')}}">
                    <span class="d-flex align-items-center align-middle">
                      <i class="flex-shrink-0 ri-file-text-line ri-22px me-3"></i>
                      <span class="flex-grow-1 align-middle">Billing</span>
                    </span>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:void(0);">
                    <i class='ri-gift-line ri-22px me-2'></i>
                    <span class="align-middle">Gift card</span>
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
