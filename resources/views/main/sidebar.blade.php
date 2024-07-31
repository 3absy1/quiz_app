<nav class="navbar navbar-vertical navbar-expand-lg" style="display:none;">
    <script>
        var navbarStyle = localStorage.getItem("phoenixNavbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
        document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->
        <div class="navbar-vertical-content">
        <ul class="navbar-nav flex-column" id="navbarVerticalNav">
            <li class="nav-item">
                <!-- parent pages-->
                <span class="nav-item-wrapper">
                    <a class="nav-link label-1 {{ Request::url() == route('admin') ? 'active' : '' }} "
                        href="{{ route('admin') }}" role="button">
                        <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon">
                            </div><span class="nav-link-icon"><i class="fa-solid fa-house-chimney mt-1"></i></span><span
                                class="nav-link-text">Home</span>
                        </div>
                    </a>
                </span>
            </li>
            <li class="nav-item">
                <!-- parent pages-->
                <span class="nav-item-wrapper">
                    <a class="nav-link label-1 {{ Request::url() == route('teachers')  ? 'active' : '' }}  "
                        href="{{ route('teachers') }}" role="button">
                        <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon">
                            </div><span class="nav-link-icon"><i class="fa-solid fa-table mt-1"></i></span><span
                                class="nav-link-text">Teachers </span>
                        </div>
                    </a>
                </span>
            </li>
            <li class="nav-item">
                <!-- parent pages-->
                <span class="nav-item-wrapper">
                    <a class="nav-link label-1 {{ Request::url() == route('students') ? 'active' : '' }}  "
                        href="{{ route('students') }}" role="button">
                        <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon">
                            </div><span class="nav-link-icon"><i class="fa-solid fa-table mt-1"></i></span><span
                                class="nav-link-text">Students </span>
                        </div>
                    </a>
                </span>
            </li>
        {{-- <li class="nav-item">
            <!-- parent pages-->
            <span class="nav-item-wrapper">
                <a class="nav-link label-1 {{Request::url() == route('merge.index') || Request::url() == route('merge.import') || Request::url() == route('merge.import-file') || Request::url() == route('merge.upload') || Request::url() == route('merge.file') ? 'active':''}}  " href="{{ route('merge.index') }}" role="button"  >
                <div class="d-flex align-items-center"><div class="dropdown-indicator-icon">
                </div><span class="nav-link-icon"><i class="fa-solid fa-file mt-1"></i></span><span class="nav-link-text">Merge Table</span>
            </div></a>
        </span>
        </li> --}}



        </ul>
</div>
</div>
<div class="navbar-vertical-footer"><button onclick="toggleNavArrow()" class="btn navbar-vertical-toggle border-0 fw-semi-bold w-100 text-start white-space-nowrap"><span id="toggleArrow" class="fas fa-arrow-right d-none fs-0"></span><span class="navbar-vertical-footer-text ms-2"> <span class="fas fa-arrow-left  ms-2"></span> Collapsed View </span></span></button></div>
</nav>
