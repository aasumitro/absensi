<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
            <div class="d-flex align-items-center">
                <!-- Search form -->
                <form class="navbar-search form-inline" id="navbar-search-main">
                    <div class="input-group input-group-merge search-bar">
                        <span class="input-group-text" id="topbar-addon">
                            <span class="fas fa-search"></span>
                        </span>
                        <input
                            type="text"
                            class="form-control"
                            id="topbarInputIconLeft"
                            placeholder="Search"
                            aria-label="Search"
                            aria-describedby="topbar-addon"
                        >
                    </div>
                </form>
            </div>
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center">

                <li class="nav-item dropdown">
                    <a
                        class="nav-link text-dark me-lg-3 icon-notifications dropdown-toggle"
                        data-unread-notifications="true"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <span class="icon icon-sm">
                            <span class="fas fa-bell bell-shake"></span>
                            <span class="icon-badge rounded-circle unread-notifications"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-lg dropdown-menu-center mt-2 py-0">
                        <div class="list-group list-group-flush">
                            <a href="#" class="text-center text-primary fw-bold border-bottom border-light py-3">
                                Notifications
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-bottom border-light">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <img
                                            alt="Image placeholder"
                                            src="{{default_profile_picture("Jose Leos")}}"
                                            class="user-avatar lg-avatar rounded-circle"
                                        >
                                    </div>
                                    <div class="col ps-0 ms-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="h6 mb-0 text-small">Jose Leos</h4>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-danger">a few moments ago</small>
                                            </div>
                                        </div>
                                        <p class="font-small mt-1 mb-0">
                                            Added you to an event "Project stand-up" tomorrow at 12:30 AM.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a
                                href="#"
                                class="dropdown-item text-center text-primary fw-bold rounded-bottom py-3"
                            >
                                View all
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle pt-1 px-0"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <div class="media d-flex align-items-center">
                            <img
                                class="user-avatar md-avatar rounded-circle"
                                alt="Image placeholder"
                                src="{{default_profile_picture(auth()->user()->username)}}"
                            >
                            <div class="media-body ms-3 text-dark align-items-center d-none d-lg-block">
                                <span class="mb-0 font-small fw-bold ">
                                   Hello, {{ auth()->user()->username }}
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-0">
                        <a
                            class="dropdown-item rounded-top fw-bold"
                            href="#"
                            onclick="showNotification('error', 'Feature currently not implemented yet!')"
                        >
                            <span class="far fa-user-circle"></span>
                            My Profile
                        </a>
                        <div role="separator" class="dropdown-divider my-0"></div>
                        <a
                            class="dropdown-item rounded-bottom fw-bold"
                            href="#"
                            data-bs-toggle="modal"
                            data-bs-target="#logoutModal"
                        >
                            <span class="fas fa-sign-out-alt text-danger"></span>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
