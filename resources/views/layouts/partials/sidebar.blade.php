<nav
    id="sidebarMenu"
    class="sidebar d-md-block bg-dark text-white collapse"
    data-simplebar
>
    <div class="sidebar-inner px-4 pt-3">
        <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="user-avatar lg-avatar me-4">
                    <img
                        src="{{asset('assets/vendor/volt/dist/img/icons/github.svg')}}"
                        class="card-img-top rounded-circle border-white"
                        alt="Bonnie Green"
                    >
                </div>
                <div class="d-block">
                    <h2 class="h6">Hello, {{ auth()->user()->username }}</h2>
                    <a
                        href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#logoutModal"
                        class="btn btn-secondary text-dark btn-xs"
                    >
                        <span class="me-2">
                            <span class="fas fa-sign-out-alt"></span>
                        </span>
                        Sign Out
                    </a>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a
                    href="#sidebarMenu"
                    class="fas fa-times"
                    data-bs-toggle="collapse"
                    data-bs-target="#sidebarMenu"
                    aria-controls="sidebarMenu"
                    aria-expanded="true"
                    aria-label="Toggle navigation"
                ></a>
            </div>
        </div>

        @yield('sidebar-menu')
    </div>
</nav>
