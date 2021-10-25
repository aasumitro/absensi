<ul class="nav flex-column pt-3 pt-md-0">
    <li class="nav-item">
        <a href="#" class="nav-link d-flex align-items-center disabled">
            <span class="sidebar-icon">
                <img
                    src="{{asset('assets/vendor/volt/dist/img/brand/light.svg')}}"
                    height="20"
                    width="20"
                    alt="Volt Logo"
                >
            </span>
            <span class="mt-1 ms-1 sidebar-text">OkSetda Absensi</span>
        </a>
    </li>
    <li class="nav-item {{Route::is('home') ? 'active' : ''}} mt-3">
        <a href="{{route('home')}}" class="nav-link">
            <span class="sidebar-icon">
                <span class="fas fa-home"></span>
            </span>
            <span class="sidebar-text">Beranda</span>
        </a>
    </li>
    <li class="nav-item">
        <span
            class="nav-link  d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target="#submenu-dashboard"
        >
            <span>
                <span class="sidebar-icon">
                    <span class="fas fa-chart-pie"></span>
                </span>
                <span class="sidebar-text">Dashboard</span>
            </span>
            <span class="link-arrow">
                <span class="fas fa-chevron-right"></span>
            </span>
        </span>
        <div
            class="multi-level collapse {{ Route::is('dashboard.*') ? 'show' : '' }}"
            role="list"
            id="submenu-dashboard"
            aria-expanded="false"
        >
            <ul class="flex-column nav">
                <li class="nav-item {{ Route::is('dashboard.summary') ? 'active' : '' }}">
                    <a
                        class="nav-link"
                        href="{{ route('dashboard.summary') }}"
                    >
                        <span class="sidebar-text">Ringkasan</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('dashboard.scope-office') ? 'active' : '' }}">
                    <a
                        class="nav-link"
                        href="{{ route('dashboard.scope-office') }}"
                    >
                        <span class="sidebar-text">Berdasarkan SKPD</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li role="separator" class="dropdown-divider mt-4 mb-4 border-black"></li>
    <li class="nav-item">
        <span
            class="nav-link d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target="#submenu-offices"
        >
            <span>
                <span class="sidebar-icon">
                    <span class="fas fa-building"></span>
                </span>
                <span class="sidebar-text">Kantor</span>
            </span>
            <span class="link-arrow">
                <span class="fas fa-chevron-right"></span>
            </span>
        </span>
        <div
            class="multi-level collapse {{ Route::is('offices.*') ? 'show' : '' }}"
            role="list"
            id="submenu-offices"
            aria-expanded="false"
        >
            <ul class="flex-column nav">
                <li class="nav-item {{ Route::is('offices.departments') ? 'active' : '' }}">
                    <a
                        class="nav-link"
                        href="{{ route('offices.departments') }}"
                    >
                        <span class="sidebar-text">SKPD</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('offices.devices') ? 'active' : '' }}">
                    <a
                        class="nav-link"
                        href="{{ route('offices.devices') }}"
                    >
                        <span class="sidebar-text">Perangkat</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('offices.peoples') ? 'active' : '' }}">
                    <a
                        class="nav-link"
                        href="{{ route('offices.peoples') }}"
                    >
                        <span class="sidebar-text">Pegawai</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li role="separator" class="dropdown-divider mt-4 mb-4 border-black"></li>
    <li class="nav-item">
        <span
            class="nav-link d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target="#submenu-users"
        >
            <span>
                <span class="sidebar-icon">
                    <span class="fas fa-users"></span>
                </span>
                <span class="sidebar-text">Pengguna</span>
            </span>
            <span class="link-arrow">
                <span class="fas fa-chevron-right"></span>
            </span>
        </span>
        <div
            class="multi-level collapse {{ Route::is('users.*') ? 'show' : '' }}"
            role="list"
            id="submenu-users"
            aria-expanded="false"
        >
            <ul class="flex-column nav">
                <li class="nav-item {{ Route::is('users.accounts') ? 'active' : '' }}">
                    <a
                        class="nav-link"
                        href="{{ route('users.accounts') }}"
                    >
                        <span class="sidebar-text">Akun</span>
                    </a>
                </li>

                <li class="nav-item {{ Route::is('users.submissions') ? 'active' : '' }}">
                    <a
                        class="nav-link"
                        href="{{ route('users.submissions') }}"
                    >
                        <span class="sidebar-text">Pengajuan</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <span
            class="nav-link  d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target="#submenu-setting"
        >
            <span>
                <span class="sidebar-icon">
                    <span class="fas fa-cogs"></span>
                </span>
                <span class="sidebar-text">Pengaturan</span>
            </span>
            <span class="link-arrow">
                <span class="fas fa-chevron-right"></span>
            </span>
        </span>
        <div
            class="multi-level collapse  {{ Route::is('settings.*') ? 'show' : '' }}"
            role="list"
            id="submenu-setting"
            aria-expanded="false"
        >
            <ul class="flex-column nav">
                <li class="nav-item {{ Route::is('settings.system') ? 'active' : '' }}">
                    <a
                        class="nav-link"
                        href="{{ route('settings.system') }}"
                    >
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item  {{Route::is('settings.mobile') ? 'active' : ''}}">
                    <a
                        class="nav-link"
                        href="{{route('settings.mobile')}}"
                    >
                        <span class="sidebar-text">Mobile</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li role="separator" class="dropdown-divider mt-4 mb-4 border-black"></li>
    <li class="nav-item">
        <a
            href="{{url('docs')}}"
            target="_blank"
            class="nav-link d-flex align-items-center"
        >
            <span class="sidebar-icon">
                <span class="fas fa-book"></span>
            </span>
            <span class="sidebar-text">
                Dokumentasi
                <span class="badge badge-md bg-secondary ms-1 text-dark">
                    v1.0
                </span>
            </span>
        </a>
    </li>
</ul>
