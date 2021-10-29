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
                @livewire('notification')

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
                                   Halo, {{ auth()->user()->username }}
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-0">
                        <a
                            class="dropdown-item rounded-top fw-bold"
                            href="#"
                            onclick="showNotification('error', 'Aksi tidak diizinkan, silahkan lakukan perubahan pada menu [Pengguna/Akun]', 10000)"
                        >
                            <span class="far fa-user-circle"></span>
                            Profil Saya
                        </a>
                        <div role="separator" class="dropdown-divider my-0"></div>
                        <a
                            class="dropdown-item rounded-bottom fw-bold"
                            href="#"
                            data-bs-toggle="modal"
                            data-bs-target="#logoutModal"
                        >
                            <span class="fas fa-sign-out-alt text-danger"></span>
                            Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
