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
                        src="{{default_profile_picture(auth()->user()->username)}}"
                        class="card-img-top rounded-circle border-white"
                        alt="{{ auth()->user()->username }}"
                    >
                </div>
                <div class="d-block">
                    <h2 class="h6">Halo, {{ auth()->user()->username }}</h2>
                    <a
                        href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#logoutModal"
                        class="btn btn-secondary text-dark btn-xs"
                    >
                        <span class="me-2">
                            <span class="fas fa-sign-out-alt"></span>
                        </span>
                        Keluar
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

        @if(auth()->user()->role_id === ROOT_ROLE_ID)
            @include('components.menu.root')
        @endif

        @if(auth()->user()->role_id === ADMIN_ROLE_ID)
            @include('components.menu.admin')
        @endif

        @if(auth()->user()->role_id === OPERATOR_ROLE_ID)
            @include('components.menu.operator')
        @endif
    </div>
</nav>
