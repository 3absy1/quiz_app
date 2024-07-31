<nav class="navbar navbar-top navbar-expand" id="navbarDefault" style="display:none;">
    <div class="collapse navbar-collapse justify-content-between">
    <div class="navbar-logo">
        <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
        <a class="navbar-brand me-1 me-sm-3" href="{{ route('admin') }}">
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center"><img src="{{asset('assets')}}/img/icons/logo.png" alt="phoenix" width="27" />
            <p class="logo-text ms-2 d-none d-sm-block">Quiz App </p>
            </div>
        </div>
        </a>
    </div>
    <div class="search-box d-none d-lg-block" data-list='{"valueNames":["title"]}' style="width:25rem;">
        <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control form-control-sm rounded-pill search-input fuzzy-search" id="searchBox" type="search" placeholder="Search..." aria-label="Search" />
        <span class="fas fa-search search-box-icon"></span>
        </form>
        <div class="btn-close position-absolute end-0 top-50 translate-middle cursor-pointer shadow-none" data-bs-dismiss="search"><button class="btn btn-link btn-close-falcon p-0" aria-label="Close"></button></div>
        <div class="dropdown-menu border font-base start-0 py-0 overflow-hidden w-100">
        <div class="scrollbar list pb-3" style="max-height: 30rem;">
            <h6 class="dropdown-header text-1000 fs--2 py-2">2 <span class="text-500">results</span></h6>

            <hr class="text-200 my-0" />
            <h6 class="dropdown-header text-1000 fs--1 border-bottom py-2 lh-sm">Quick Links</h6><a class="dropdown-item" href="{{ route('teachers') }}">
            <div class="d-flex align-items-center">
                <div class="fw-normal text-1000 title"><span class="fa-solid fa-link text-900" data-fa-transform="shrink-2"></span> Teachers</div>
            </div>
            </a>

            <a class="dropdown-item" href="{{ route('students') }}">
            <div class="d-flex align-items-center">
                <div class="fw-normal text-1000 title"> <span class="fa-solid fa-link text-900" data-fa-transform="shrink-2"></span> Students </div>
            </div>
            </a>

        </div>
        <div class="text-center">
            <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
        </div>
        </div>
    </div>
    <ul class="navbar-nav navbar-nav-icons flex-row">
        <li class="nav-item">
        <div class="theme-control-toggle fa-icon-wait px-2"><input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="phoenixTheme" value="sun" /><label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon" data-feather="moon"></span></label><label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon" data-feather="sun"></span></label></div>
        </li>
        <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="avatar avatar-l ">
            <img class="rounded-circle " src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="" />
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
            <div class="card position-relative border-0">
            <div class="card-body p-0">
                <div class="text-center pt-4 pb-3">
                <div class="avatar avatar-xl ">
                    <img class="rounded-circle " src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="" />
                </div>
                <h6 class="mt-2 text-black">{{ Auth::user()->name }}</h6>
                </div>
                {{-- <div class="mb-3 mx-3"><input class="form-control form-control-sm" id="statusUpdateInput" type="text" placeholder="Update your status" /></div> --}}
            </div>
            {{-- <div class="overflow-auto scrollbar" style="height: 10rem;">
                <ul class="nav d-flex flex-column mb-2 pb-1">
                <li class="nav-item"><a class="nav-link px-3" href="profile.html"> <span class="me-2 text-900" data-feather="user"></span>Profile</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"><span class="me-2 text-900" data-feather="pie-chart"></span>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="lock"></span>Posts &amp; Activity</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="settings"></span>Settings &amp; Privacy </a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="help-circle"></span>Help Center</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="globe"></span>Language</a></li>
                </ul>
            </div> --}}
            <div class="card-footer p-0 border-top">
                {{-- <ul class="nav d-flex flex-column my-3">
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="user-plus"></span>Add another account</a></li>
                </ul> --}}
                <hr />
                <div class="px-3">
                    <a class="btn btn-phoenix-secondary d-flex flex-center w-100"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <span class="me-2" data-feather="log-out"> </span>
                        Sign out
                    </a>
                    </div>
                <div class="my-2 text-center fw-bold fs--2 text-600"><a class="text-600 me-1" href="#!">Privacy policy</a>&bull;<a class="text-600 mx-1" href="#!">Terms</a>&bull;<a class="text-600 ms-1" href="#!">Cookies</a></div>
            </div>
            </div>
        </div>
        </li>
    </ul>
    </div>
</nav>
