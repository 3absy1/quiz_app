
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->
        <div class="navbar-vertical-content">
        <ul class="navbar-nav flex-column" id="navbarVerticalNav">
            <li class="nav-item">
            <!-- parent pages-->
            <span class="nav-item-wrapper">
                <a class="nav-link label-1 active" href="index.html" role="button"  >
                <div class="d-flex align-items-center"><div class="dropdown-indicator-icon">
                </div><span class="nav-link-icon"><i class="fa-solid fa-display mt-1"></i></span><span class="nav-link-text">Dashboard</span>
            </div></a>
        </span>
        </li>


        </ul>
        <ul class="navbar-nav flex-column" id="navbarVerticalNav">
            <li class="nav-item">
            <!-- parent pages-->
            <span class="nav-item-wrapper">
                <a class="nav-link dropdown-indicator label-1 collapsed" href="#home" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="home">
                <div class="d-flex align-items-center"><div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span>
                </div><span class="nav-link-icon"><span data-feather="settings"></span></span><span class="nav-link-text">Main Setting </span>
            </div></a>
            <div class="parent-wrapper label-1 ">
        <ul class="nav  parent collapse" data-bs-parent="#navbarVerticalCollapse" id="home">
        <p class="collapsed-nav-item-title d-none">Main Setting</p>

        <li class="nav-item"><a class="nav-link " href="theme-setting.html" data-bs-toggle="" aria-expanded="false">
            <div class="d-flex align-items-center"><span class="nav-link-text">Theme Setting</div>
            </a><!-- more inner pages-->
        </li>
        <li class="nav-item"><a class="nav-link " href="general-setting.html" data-bs-toggle="" aria-expanded="false">
            <div class="d-flex align-items-center"><span class="nav-link-text">General Setting</div>
            </a><!-- more inner pages-->
        </li>
        <li class="nav-item"><a class="nav-link " href="modules-setting.html" data-bs-toggle="" aria-expanded="false">
            <div class="d-flex align-items-center"><span class="nav-link-text">Modules Setting</div>
        </a><!-- more inner pages-->
        </li>
        </ul>
        </div>
            </span>
            <!-- parent pages-->
            <span class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1 collapsed" href="#events" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="events"><div class="d-flex align-items-center"><div class="dropdown-indicator-icon"><svg class="svg-inline--fa fa-caret-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z"></path></svg><!-- <span class="fas fa-caret-right"></span> Font Awesome fontawesome.com --></div><span class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg></span><span class="nav-link-text">Staff Management </span></div></a>
            <div class="parent-wrapper label-1">
                <ul class="nav parent collapse" data-bs-parent="#navbarVerticalCollapse" id="events" style="">
                <p class="collapsed-nav-item-title d-none">Staff Management </p>
                <li class="nav-item"><a class="nav-link" href="users-access.html" data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-text">Users Access</span></div>
                    </a><!-- more inner pages-->
                </li>
                <li class="nav-item"><a class="nav-link " href="user-roles.html" data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-text">Users Roles</span></div>
                    </a><!-- more inner pages-->
                </li>
                </ul>
            </div></span>
        </li>
        </ul>
    </div>
    </div>
    <div class="navbar-vertical-footer"><button onclick="toggleNavArrow()" class="btn navbar-vertical-toggle border-0 fw-semi-bold w-100 text-start white-space-nowrap"><span id="toggleArrow" class="fas fa-arrow-right d-none fs-0"></span><span class="navbar-vertical-footer-text ms-2"> <span class="fas fa-arrow-left  ms-2"></span> Collapsed View </span></span></button></div>
    </nav>

    <nav class="navbar navbar-top navbar-slim navbar-expand" id="navbarSlim" style="display:none;">
    <div class="collapse navbar-collapse justify-content-between">
    <div class="navbar-logo">
        <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
        <a class="navbar-brand navbar-brand" href="index.html">phoenix <span class="text-1000">slim</span></a>
    </div>
    <ul class="navbar-nav navbar-nav-icons flex-row">
        <li class="nav-item">
        <div class="theme-control-toggle fa-ion-wait pe-2 theme-control-toggle-slim"><input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="phoenixTheme" value="dark" /><label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon me-1 d-none d-sm-block" data-feather="moon"></span><span class="fs--1 fw-bold">Dark</span></label><label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon me-1 d-none d-sm-block" data-feather="sun"></span><span class="fs--1 fw-bold">Light</span></label></div>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link" id="navbarDropdownNotification" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span data-feather="bell" style="height:12px;width:12px;"></span></a>
        <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border border-300 navbar-dropdown-caret" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
            <div class="card position-relative border-0">
            <div class="card-header p-2">
                <div class="d-flex justify-content-between">
                <h5 class="text-black mb-0">Notificatons</h5><button class="btn btn-link p-0 fs--1 fw-normal" type="button">Mark all as read</button>
                </div>
            </div>
            <div class="card-body p-0"></div>
            <div class="scrollbar-overlay">
                <div class="overflow-auto" style="height: 27rem;">
                <div class="border-300">
                    <div class="p-3 border-300 notification-card position-relative read border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                        <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                            <h4 class="fs--1 text-black">Jessie Samson</h4>
                            <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>💬</span>Mentioned you in a comment.<span class="ms-2 text-500 fw-bold fs--2">10m</span></p>
                            <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:41 AM </span>August 7,2021</p>
                        </div>
                        </div>
                        <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                        </div>
                    </div>
                    </div>
                    <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                        <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3">
                            <div class="avatar-name rounded-circle"><span>J</span></div>
                        </div>
                        <div class="me-3 flex-1">
                            <h4 class="fs--1 text-black">Jane Foster</h4>
                            <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>📅</span>Created an event.<span class="ms-2 text-500 fw-bold fs--2">20m</span></p>
                            <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:20 AM </span>August 7,2021</p>
                        </div>
                        </div>
                        <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                        </div>
                    </div>
                    </div>
                    <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                        <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle avatar-placeholder" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                            <h4 class="fs--1 text-black">Jessie Samson</h4>
                            <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>👍</span>Liked your comment.<span class="ms-2 text-500 fw-bold fs--2">1h</span></p>
                            <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">9:30 AM </span>August 7,2021</p>
                        </div>
                        </div>
                        <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="border-300">
                    <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                        <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                            <h4 class="fs--1 text-black">Kiera Anderson</h4>
                            <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1 fs--2'>💬</span>Mentioned you in a comment.<span class="ms-2 text-500 fw-bold fs--2"></span></p>
                            <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">9:11 AM </span>August 7,2021</p>
                        </div>
                        </div>
                        <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                        </div>
                    </div>
                    </div>
                    <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                        <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                            <h4 class="fs--1 text-black">Herman Carter</h4>
                            <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>👤</span>Tagged you in a comment.<span class="ms-2 text-500 fw-bold fs--2"></span></p>
                            <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:58 PM </span>August 7,2021</p>
                        </div>
                        </div>
                        <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                        </div>
                    </div>
                    </div>
                    <div class="p-3 border-300 notification-card position-relative read ">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                        <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                            <h4 class="fs--1 text-black">Benjamin Button</h4>
                            <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>👍</span>Liked your comment.<span class="ms-2 text-500 fw-bold fs--2"></span></p>
                            <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:18 AM </span>August 7,2021</p>
                        </div>
                        </div>
                        <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="card-footer p-0 border-top border-0">
                <div class="my-2 text-center fw-bold fs--2 text-600"><a class="fw-bolder" href="notifications.html">Notification history</a></div>
            </div>
            </div>
        </div>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link" id="navbarDropdownNindeDots" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg width="10" height="10" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
            <circle cx="2" cy="8" r="2" fill="currentColor"></circle>
            <circle cx="2" cy="14" r="2" fill="currentColor"></circle>
            <circle cx="8" cy="8" r="2" fill="currentColor"></circle>
            <circle cx="8" cy="14" r="2" fill="currentColor"></circle>
            <circle cx="14" cy="8" r="2" fill="currentColor"></circle>
            <circle cx="14" cy="14" r="2" fill="currentColor"></circle>
            <circle cx="8" cy="2" r="2" fill="currentColor"></circle>
            <circle cx="14" cy="2" r="2" fill="currentColor"></circle>
            </svg></a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-nide-dots shadow border border-300" aria-labelledby="navbarDropdownNindeDots">
            <div class="card bg-white position-relative border-0">
            <div class="card-body pt-3 px-3 pb-0 overflow-auto scrollbar" style="height: 20rem;">
                <div class="row text-center align-items-center gx-0 gy-0">
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/behance.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Behance</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-cloud.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Cloud</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/slack.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Slack</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/gitlab.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Gitlab</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/bitbucket.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">BitBucket</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-drive.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Drive</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/trello.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Trello</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/figma.png" alt="" width="20" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Figma</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/twitter.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Twitter</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/pinterest.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Pinterest</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/ln.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Linkedin</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-maps.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Maps</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-photos.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Photos</p>
                    </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/spotify.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Spotify</p>
                    </a></div>
                </div>
            </div>
            </div>
        </div>
        </li>
        <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Olivia <span class="fa-solid fa-chevron-down fs--2"></span></a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
            <div class="card position-relative border-0">
            <div class="card-body p-0">
                <div class="text-center pt-4 pb-3">
                <div class="avatar avatar-xl ">
                    <img class="rounded-circle " src="assets/img/team/avatar.png" alt="" />
                </div>
                <h6 class="mt-2 text-black">Jerry Seinfield</h6>
                </div>
                <div class="mb-3 mx-3"><input class="form-control form-control-sm" id="statusUpdateInput" type="text" placeholder="Update your status" /></div>
            </div>
            <div class="overflow-auto scrollbar" style="height: 10rem;">
                <ul class="nav d-flex flex-column mb-2 pb-1">
                <li class="nav-item"><a class="nav-link px-3" href="profile.html"> <span class="me-2 text-900" data-feather="user"></span>Profile</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"><span class="me-2 text-900" data-feather="pie-chart"></span>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="lock"></span>Posts &amp; Activity</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="settings"></span>Settings &amp; Privacy </a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="help-circle"></span>Help Center</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="globe"></span>Language</a></li>
                </ul>
            </div>
            <div class="card-footer p-0 border-top">
                <ul class="nav d-flex flex-column my-3">
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="user-plus"></span>Add another account</a></li>
                </ul>
                <hr />
                <div class="px-3"> <a class="btn btn-phoenix-secondary d-flex flex-center w-100" href="#!"> <span class="me-2" data-feather="log-out"> </span>Sign out</a></div>
                <div class="my-2 text-center fw-bold fs--2 text-600"><a class="text-600 me-1" href="#!">Privacy policy</a>&bull;<a class="text-600 mx-1" href="#!">Terms</a>&bull;<a class="text-600 ms-1" href="#!">Cookies</a></div>
            </div>
            </div>
        </div>
        </li>
    </ul>
    </div>
    </nav>
    <nav class="navbar navbar-top navbar-expand-lg" id="navbarTopNew" style="display:none;">
    <div class="navbar-logo">
    <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToplCollapse" aria-controls="navbarToplCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="index.html">
        <div class="d-flex align-items-center">
        <div class="d-flex align-items-center"><img src="assets/img/icons/logo.png" alt="phoenix" width="27" />
            <p class="logo-text ms-2 d-none d-sm-block">phoenix</p>
        </div>
        </div>
    </a>
    </div>

    <ul class="navbar-nav navbar-nav-icons flex-row">
    <li class="nav-item">
        <div class="theme-control-toggle fa-icon-wait px-2"><input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="phoenixTheme" value="dark" /><label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon" data-feather="moon"></span></label><label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon" data-feather="sun"></span></label></div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-700" data-feather="bell" style="height:20px;width:20px;"></span></a>
        <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border border-300 navbar-dropdown-caret" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
        <div class="card position-relative border-0">
            <div class="card-header p-2">
            <div class="d-flex justify-content-between">
                <h5 class="text-black mb-0">Notificatons</h5><button class="btn btn-link p-0 fs--1 fw-normal" type="button">Mark all as read</button>
            </div>
            </div>
            <div class="card-body p-0"></div>
            <div class="scrollbar-overlay">
            <div class="overflow-auto" style="height: 27rem;">
                <div class="border-300">
                <div class="p-3 border-300 notification-card position-relative read border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Jessie Samson</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>💬</span>Mentioned you in a comment.<span class="ms-2 text-500 fw-bold fs--2">10m</span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:41 AM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3">
                        <div class="avatar-name rounded-circle"><span>J</span></div>
                        </div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Jane Foster</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>📅</span>Created an event.<span class="ms-2 text-500 fw-bold fs--2">20m</span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:20 AM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle avatar-placeholder" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Jessie Samson</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>👍</span>Liked your comment.<span class="ms-2 text-500 fw-bold fs--2">1h</span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">9:30 AM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="border-300">
                <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Kiera Anderson</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1 fs--2'>💬</span>Mentioned you in a comment.<span class="ms-2 text-500 fw-bold fs--2"></span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">9:11 AM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Herman Carter</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>👤</span>Tagged you in a comment.<span class="ms-2 text-500 fw-bold fs--2"></span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:58 PM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                <div class="p-3 border-300 notification-card position-relative read ">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Benjamin Button</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>👍</span>Liked your comment.<span class="ms-2 text-500 fw-bold fs--2"></span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:18 AM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="card-footer p-0 border-top border-0">
            <div class="my-2 text-center fw-bold fs--2 text-600"><a class="fw-bolder" href="pages/pages/notifications.html">Notification history</a></div>
            </div>
        </div>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link" id="navbarDropdownNindeDots" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg width="16" height="16" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
            <circle cx="2" cy="8" r="2" fill="currentColor"></circle>
            <circle cx="2" cy="14" r="2" fill="currentColor"></circle>
            <circle cx="8" cy="8" r="2" fill="currentColor"></circle>
            <circle cx="8" cy="14" r="2" fill="currentColor"></circle>
            <circle cx="14" cy="8" r="2" fill="currentColor"></circle>
            <circle cx="14" cy="14" r="2" fill="currentColor"></circle>
            <circle cx="8" cy="2" r="2" fill="currentColor"></circle>
            <circle cx="14" cy="2" r="2" fill="currentColor"></circle>
        </svg></a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-nide-dots shadow border border-300" aria-labelledby="navbarDropdownNindeDots">
        <div class="card bg-white position-relative border-0">
            <div class="card-body pt-3 px-3 pb-0 overflow-auto scrollbar" style="height: 20rem;">
            <div class="row text-center align-items-center gx-0 gy-0">
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/behance.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Behance</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-cloud.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Cloud</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/slack.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Slack</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/gitlab.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Gitlab</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/bitbucket.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">BitBucket</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-drive.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Drive</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/trello.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Trello</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/figma.png" alt="" width="20" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Figma</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/twitter.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Twitter</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/pinterest.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Pinterest</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/ln.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Linkedin</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-maps.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Maps</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-photos.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Photos</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/spotify.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Spotify</p>
                </a></div>
            </div>
            </div>
        </div>
        </div>
    </li>
    <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="avatar avatar-l ">
            <img class="rounded-circle " src="assets/img/team/avatar.png" alt="" />
        </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
        <div class="card position-relative border-0">
            <div class="card-body p-0">
            <div class="text-center pt-4 pb-3">
                <div class="avatar avatar-xl ">
                <img class="rounded-circle " src="assets/img/team/avatar.png" alt="" />
                </div>
                <h6 class="mt-2 text-black">Jerry Seinfield</h6>
            </div>
            <div class="mb-3 mx-3"><input class="form-control form-control-sm" id="statusUpdateInput" type="text" placeholder="Update your status" /></div>
            </div>
            <div class="overflow-auto scrollbar" style="height: 10rem;">
            <ul class="nav d-flex flex-column mb-2 pb-1">
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="user"></span>Profile</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"><span class="me-2 text-900" data-feather="pie-chart"></span>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="lock"></span>Posts &amp; Activity</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="settings"></span>Settings &amp; Privacy </a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="help-circle"></span>Help Center</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="globe"></span>Language</a></li>
            </ul>
            </div>
            <div class="card-footer p-0 border-top">
            <ul class="nav d-flex flex-column my-3">
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="user-plus"></span>Add another account</a></li>
            </ul>
            <hr />
            <div class="px-3"> <a class="btn btn-phoenix-secondary d-flex flex-center w-100" href="#!"> <span class="me-2" data-feather="log-out"> </span>Sign out</a></div>
            <div class="my-2 text-center fw-bold fs--2 text-600"><a class="text-600 me-1" href="#!">Privacy policy</a>&bull;<a class="text-600 mx-1" href="#!">Terms</a>&bull;<a class="text-600 ms-1" href="#!">Cookies</a></div>
            </div>
        </div>
        </div>
    </li>
    </ul>
    </nav>
    <nav class="navbar navbar-top navbar-slim justify-content-between navbar-expand-lg" id="navbarTopSlimNew" style="display:none;">
    <div class="navbar-logo">
    <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToplCollapse" aria-controls="navbarToplCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    <a class="navbar-brand navbar-brand" href="index.html">phoenix <span class="text-1000">slim</span></a>
    </div>
    <div class="collapse navbar-collapse navbar-top-collapse order-1 order-lg-0 justify-content-center" id="navbarToplCollapse">
    <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">
        <li class="nav-item dropdown">
        <a class="nav-link  lh-1" href="index.html" role="button">Dashboard</a>
        </li>
        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle lh-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dashboards-setting">Main Setting</a>
        <div class="dropdown-menu navbar-dropdown-caret py-0" aria-labelledby="dashboards">
            <div class="dropdown-menu-content py-2">
            <a class="dropdown-item fw-semi-bold" href="theme-setting.html">Theme Setting</a>
            <a class="dropdown-item fw-semi-bold" href="general-setting.html">General Setting</a>
            <a class="dropdown-item fw-semi-bold" href="modules-setting.html">Modules Theme</a>
        </div>
        </li>
        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle lh-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dashboards-setting">Staff Management</a>
        <div class="dropdown-menu navbar-dropdown-caret py-0" aria-labelledby="dashboards">
            <div class="dropdown-menu-content py-2">
            <a class="dropdown-item fw-semi-bold" href="users-access.html">Users Access</a>
            <a class="dropdown-item fw-semi-bold" href="user-roles.html">Users Roles</a>
        </div>
        </li>

    </ul>
    </div>
    <ul class="navbar-nav navbar-nav-icons flex-row">
    <li class="nav-item">
        <div class="theme-control-toggle fa-ion-wait pe-2 theme-control-toggle-slim"><input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="phoenixTheme" value="dark" /><label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon me-1 d-none d-sm-block" data-feather="moon"></span><span class="fs--1 fw-bold">Dark</span></label><label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon me-1 d-none d-sm-block" data-feather="sun"></span><span class="fs--1 fw-bold">Light</span></label></div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link" id="navbarDropdownNotification" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span data-feather="bell" style="height:12px;width:12px;"></span></a>
        <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border border-300 navbar-dropdown-caret" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
        <div class="card position-relative border-0">
            <div class="card-header p-2">
            <div class="d-flex justify-content-between">
                <h5 class="text-black mb-0">Notificatons</h5><button class="btn btn-link p-0 fs--1 fw-normal" type="button">Mark all as read</button>
            </div>
            </div>
            <div class="card-body p-0"></div>
            <div class="scrollbar-overlay">
            <div class="overflow-auto" style="height: 27rem;">
                <div class="border-300">
                <div class="p-3 border-300 notification-card position-relative read border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Jessie Samson</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>💬</span>Mentioned you in a comment.<span class="ms-2 text-500 fw-bold fs--2">10m</span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:41 AM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3">
                        <div class="avatar-name rounded-circle"><span>J</span></div>
                        </div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Jane Foster</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>📅</span>Created an event.<span class="ms-2 text-500 fw-bold fs--2">20m</span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:20 AM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle avatar-placeholder" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Jessie Samson</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>👍</span>Liked your comment.<span class="ms-2 text-500 fw-bold fs--2">1h</span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">9:30 AM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="border-300">
                <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Kiera Anderson</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1 fs--2'>💬</span>Mentioned you in a comment.<span class="ms-2 text-500 fw-bold fs--2"></span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">9:11 AM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                <div class="p-3 border-300 notification-card position-relative unread border-bottom">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Herman Carter</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>👤</span>Tagged you in a comment.<span class="ms-2 text-500 fw-bold fs--2"></span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:58 PM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                <div class="p-3 border-300 notification-card position-relative read ">
                    <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="d-flex">
                        <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="assets/img/team/avatar.png" alt="" /></div>
                        <div class="me-3 flex-1">
                        <h4 class="fs--1 text-black">Benjamin Button</h4>
                        <p class="fs--1 text-1000 mb-2 mb-sm-3"><span class='me-1'>👍</span>Liked your comment.<span class="ms-2 text-500 fw-bold fs--2"></span></p>
                        <p class="text-800 fs--1 mb-0"><span class="me-1 fas fa-clock"></span><span class="fw-bold">10:18 AM </span>August 7,2021</p>
                        </div>
                    </div>
                    <div class="font-sans-serif d-none d-sm-block"><button class="btn fs--2 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2 text-900"></span></button>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="documentations"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="card-footer p-0 border-top border-0">
            <div class="my-2 text-center fw-bold fs--2 text-600"><a class="fw-bolder" href="pages/pages/notifications.html">Notification history</a></div>
            </div>
        </div>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link" id="navbarDropdownNindeDots" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg width="10" height="10" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
            <circle cx="2" cy="8" r="2" fill="currentColor"></circle>
            <circle cx="2" cy="14" r="2" fill="currentColor"></circle>
            <circle cx="8" cy="8" r="2" fill="currentColor"></circle>
            <circle cx="8" cy="14" r="2" fill="currentColor"></circle>
            <circle cx="14" cy="8" r="2" fill="currentColor"></circle>
            <circle cx="14" cy="14" r="2" fill="currentColor"></circle>
            <circle cx="8" cy="2" r="2" fill="currentColor"></circle>
            <circle cx="14" cy="2" r="2" fill="currentColor"></circle>
        </svg></a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-nide-dots shadow border border-300" aria-labelledby="navbarDropdownNindeDots">
        <div class="card bg-white position-relative border-0">
            <div class="card-body pt-3 px-3 pb-0 overflow-auto scrollbar" style="height: 20rem;">
            <div class="row text-center align-items-center gx-0 gy-0">
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/behance.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Behance</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-cloud.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Cloud</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/slack.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Slack</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/gitlab.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Gitlab</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/bitbucket.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">BitBucket</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-drive.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Drive</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/trello.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Trello</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/figma.png" alt="" width="20" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Figma</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/twitter.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Twitter</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/pinterest.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Pinterest</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/ln.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Linkedin</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-maps.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Maps</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/google-photos.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Photos</p>
                </a></div>
                <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="assets/img/nav-icons/spotify.png" alt="" width="30" />
                    <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Spotify</p>
                </a></div>
            </div>
            </div>
        </div>
        </div>
    </li>
    <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Olivia <span class="fa-solid fa-chevron-down fs--2"></span></a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
        <div class="card position-relative border-0">
            <div class="card-body p-0">
            <div class="text-center pt-4 pb-3">
                <div class="avatar avatar-xl ">
                <img class="rounded-circle " src="assets/img/team/avatar.png" alt="" />
                </div>
                <h6 class="mt-2 text-black">Jerry Seinfield</h6>
            </div>
            <div class="mb-3 mx-3"><input class="form-control form-control-sm" id="statusUpdateInput" type="text" placeholder="Update your status" /></div>
            </div>
            <div class="overflow-auto scrollbar" style="height: 10rem;">
            <ul class="nav d-flex flex-column mb-2 pb-1">
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="user"></span>Profile</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"><span class="me-2 text-900" data-feather="pie-chart"></span>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="lock"></span>Posts &amp; Activity</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="settings"></span>Settings &amp; Privacy </a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="help-circle"></span>Help Center</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="globe"></span>Language</a></li>
            </ul>
            </div>
            <div class="card-footer p-0 border-top">
            <ul class="nav d-flex flex-column my-3">
                <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="user-plus"></span>Add another account</a></li>
            </ul>
            <hr />
            <div class="px-3"> <a class="btn btn-phoenix-secondary d-flex flex-center w-100" href="#!"> <span class="me-2" data-feather="log-out"> </span>Sign out</a></div>
            <div class="my-2 text-center fw-bold fs--2 text-600"><a class="text-600 me-1" href="#!">Privacy policy</a>&bull;<a class="text-600 mx-1" href="#!">Terms</a>&bull;<a class="text-600 ms-1" href="#!">Cookies</a></div>
            </div>
        </div>
        </div>
    </li>
    </ul>
    </nav>
    <div class="content">
    <!-- add your content here -->
    <div class="px-2 px-md-5"> <div class="align-items-start border-bottom">
        <div class="pt-1 w-100 mb-3 d-flex justify-content-between align-items-start">
        <div>
            <h5 class="mb-2 me-2 lh-sm"><span class="fa-solid fa-display me-2 fs-0"></span>Dashboard</h5>
        </div>
        </div>
    </div>

    <!-- dropzone file -->
    <div class="py-3">
        <form action="">
        <div class="dropzone dropzone-multiple p-0" id="my-awesome-dropzone" data-dropzone="data-dropzone" data-options='{"url":"valid/url","maxFiles":1,"dictDefaultMessage":"Choose or Drop a file here"}'>
        <div class="fallback">
            <input type="file" name="file" />
        </div>
        <div class="dz-message" data-dz-message="data-dz-message">
            <div class="dz-message-text">Drop your file here</div>
        </div>
        <div class="dz-preview dz-preview-multiple m-0 d-flex flex-column">
            <div class="d-flex pb-3 border-bottom media">
            <div class="border border-300 p-2 rounded-2 me-2"><img class="rounded-2 dz-image" src="assets/img/icons/file.png" alt="..." data-dz-thumbnail="data-dz-thumbnail" /></div>
            <div class="flex-1 d-flex flex-between-center">
                <div>
                <h6 data-dz-name="data-dz-name"></h6>
                <div class="d-flex align-items-center">
                    <p class="mb-0 fs--1 text-400 lh-1" data-dz-size="data-dz-size"></p>
                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                </div><span class="fs--2 text-danger" data-dz-errormessage="data-dz-errormessage"></span>
                </div>
                <div class="dropdown font-sans-serif"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>
                <div class="dropdown-menu dropdown-menu-end border py-2"><a class="dropdown-item" href="#!" data-dz-remove="data-dz-remove">Remove File</a></div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <button class="btn btn-primary mt-3" type="submit">submit</button>
    </form>
    </div>

    <!-- sortable setting -->
    <!-- add your content here -->
    <div class="staff-management">
        <section class="sortContainer row justify-content-around g-" id="sortable-list">
        <div class="list-item col-6">
            <div class="item-content bg-white  row justify-content-center  pt-2">
            <svg class="pull-elements col-12" xmlns="http://www.w3.org/2000/svg" width="32" height="20" viewBox="0 0 32 20" fill="none">
                <circle cx="28" cy="4" r="4" transform="rotate(90 28 4)" fill="#D9D9D9"/>
                <circle cx="16" cy="4" r="4" transform="rotate(90 16 4)" fill="#D9D9D9"/>
                <circle cx="4" cy="4" r="4" transform="rotate(90 4 4)" fill="#D9D9D9"/>
                <circle cx="28" cy="16" r="4" transform="rotate(90 28 16)" fill="#D9D9D9"/>
                <circle cx="16" cy="16" r="4" transform="rotate(90 16 16)" fill="#D9D9D9"/>
                <circle cx="4" cy="16" r="4" transform="rotate(90 4 16)" fill="#D9D9D9"/>
                </svg>
                <div class="py-5">
                <span class="order">1</span>
                </div>
            </div>
        </div>

        <div class="list-item col-6">
            <div class="item-content bg-white  row justify-content-center  pt-2">
            <svg class="pull-elements col-12" xmlns="http://www.w3.org/2000/svg" width="32" height="20" viewBox="0 0 32 20" fill="none">
                <circle cx="28" cy="4" r="4" transform="rotate(90 28 4)" fill="#D9D9D9"/>
                <circle cx="16" cy="4" r="4" transform="rotate(90 16 4)" fill="#D9D9D9"/>
                <circle cx="4" cy="4" r="4" transform="rotate(90 4 4)" fill="#D9D9D9"/>
                <circle cx="28" cy="16" r="4" transform="rotate(90 28 16)" fill="#D9D9D9"/>
                <circle cx="16" cy="16" r="4" transform="rotate(90 16 16)" fill="#D9D9D9"/>
                <circle cx="4" cy="16" r="4" transform="rotate(90 4 16)" fill="#D9D9D9"/>
                </svg>
                <div class="py-5">
                <span class="order">2</span>
                </div>
            </div>
        </div>

        <div class="list-item col-6">
            <div class="item-content bg-white row justify-content-center  pt-2">
            <svg class="pull-elements col-12" xmlns="http://www.w3.org/2000/svg" width="32" height="20" viewBox="0 0 32 20" fill="none">
                <circle cx="28" cy="4" r="4" transform="rotate(90 28 4)" fill="#D9D9D9"/>
                <circle cx="16" cy="4" r="4" transform="rotate(90 16 4)" fill="#D9D9D9"/>
                <circle cx="4" cy="4" r="4" transform="rotate(90 4 4)" fill="#D9D9D9"/>
                <circle cx="28" cy="16" r="4" transform="rotate(90 28 16)" fill="#D9D9D9"/>
                <circle cx="16" cy="16" r="4" transform="rotate(90 16 16)" fill="#D9D9D9"/>
                <circle cx="4" cy="16" r="4" transform="rotate(90 4 16)" fill="#D9D9D9"/>
                </svg>
                <div class="py-5">
                <span class="order">3</span>
                </div>
            </div>
        </div>

        <div class="list-item col-6">
            <div class="item-content bg-white row justify-content-center  pt-2">
            <svg class="pull-elements col-12" xmlns="http://www.w3.org/2000/svg" width="32" height="20" viewBox="0 0 32 20" fill="none">
                <circle cx="28" cy="4" r="4" transform="rotate(90 28 4)" fill="#D9D9D9"/>
                <circle cx="16" cy="4" r="4" transform="rotate(90 16 4)" fill="#D9D9D9"/>
                <circle cx="4" cy="4" r="4" transform="rotate(90 4 4)" fill="#D9D9D9"/>
                <circle cx="28" cy="16" r="4" transform="rotate(90 28 16)" fill="#D9D9D9"/>
                <circle cx="16" cy="16" r="4" transform="rotate(90 16 16)" fill="#D9D9D9"/>
                <circle cx="4" cy="16" r="4" transform="rotate(90 4 16)" fill="#D9D9D9"/>
                </svg>
                <div class="py-5">
                <span class="order">4</span>
                </div>
            </div>
        </div>
        <div class="list-item col-6">
            <div class="item-content bg-white row justify-content-center  pt-2">
            <svg class="pull-elements col-12" xmlns="http://www.w3.org/2000/svg" width="32" height="20" viewBox="0 0 32 20" fill="none">
                <circle cx="28" cy="4" r="4" transform="rotate(90 28 4)" fill="#D9D9D9"/>
                <circle cx="16" cy="4" r="4" transform="rotate(90 16 4)" fill="#D9D9D9"/>
                <circle cx="4" cy="4" r="4" transform="rotate(90 4 4)" fill="#D9D9D9"/>
                <circle cx="28" cy="16" r="4" transform="rotate(90 28 16)" fill="#D9D9D9"/>
                <circle cx="16" cy="16" r="4" transform="rotate(90 16 16)" fill="#D9D9D9"/>
                <circle cx="4" cy="16" r="4" transform="rotate(90 4 16)" fill="#D9D9D9"/>
                </svg>
                <div class="py-5">
                <span class="order">5</span>
                </div>
            </div>
        </div>

        <div class="list-item col-6">
            <div class="item-content bg-white row justify-content-center  pt-2">
            <svg class="pull-elements col-12" xmlns="http://www.w3.org/2000/svg" width="32" height="20" viewBox="0 0 32 20" fill="none">
                <circle cx="28" cy="4" r="4" transform="rotate(90 28 4)" fill="#D9D9D9"/>
                <circle cx="16" cy="4" r="4" transform="rotate(90 16 4)" fill="#D9D9D9"/>
                <circle cx="4" cy="4" r="4" transform="rotate(90 4 4)" fill="#D9D9D9"/>
                <circle cx="28" cy="16" r="4" transform="rotate(90 28 16)" fill="#D9D9D9"/>
                <circle cx="16" cy="16" r="4" transform="rotate(90 16 16)" fill="#D9D9D9"/>
                <circle cx="4" cy="16" r="4" transform="rotate(90 4 16)" fill="#D9D9D9"/>
                </svg>
                <div class="py-5">
                <span class="order">6</span>
                </div>
            </div>
        </div>
        </section>
    </div>


    </div>
    </div>

    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>
    <script src="vendors/feather-icons/feather.min.js"></script>
    <script  src="vendors/dropzone/dropzone.min.js"></script>
    <script src="assets/js/phoenix.js"></script>
    <script  src="vendors/jquery-3.7.1.js"></script>
    <script  src="vendors/sortablejs@1.10.2/Sortable.min.js"></script>
    <script  src="vendors/jquery.dataTables.min.js"></script>
    <script  src="vendors/dataTables.bootstrap5.min.js"></script>
    <script  src="vendors/dataTables.responsive.min.js"></script>

    <script src="assets/js/main.js"></script>
    </body>

    <!-- Mirrored from prium.github.io/phoenix/v1.6.0/apps/e-commerce/admin/customers.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Dec 2022 09:36:51 GMT -->
    </html>
