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
            <span class="sidebar-text">Home</span>
        </a>
    </li>
    <li class="nav-item mt-3">
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
            class="multi-level collapse"
            role="list"
            id="submenu-dashboard"
            aria-expanded="false"
        >
            <ul class="flex-column nav">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        target="_blank"
                        href="#"
                    >
                        <span class="sidebar-text">Summaries</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        target="_blank"
                        href="#"
                    >
                        <span class="sidebar-text">By department</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li role="separator" class="dropdown-divider mt-4 mb-3 border-black"></li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <span class="sidebar-icon">
                <span class="fas fa-envelope-open-text"></span>
            </span>
            <span class="sidebar-text">Submissions</span>
        </a>
    </li>
    <li class="nav-item">
        <span
            class="nav-link  d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target="#submenu-report"
        >
            <span>
                <span class="sidebar-icon">
                    <span class="fas fa-paste"></span>
                </span>
                <span class="sidebar-text">Reports</span>
            </span>
            <span class="link-arrow">
                <span class="fas fa-chevron-right"></span>
            </span>
        </span>
        <div
            class="multi-level collapse"
            role="list"
            id="submenu-report"
            aria-expanded="false"
        >
            <ul class="flex-column nav">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        target="_blank"
                        href="#"
                    >
                        <span class="sidebar-text">Summaries</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        target="_blank"
                        href="#"
                    >
                        <span class="sidebar-text">By employee</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        target="_blank"
                        href="#"
                    >
                        <span class="sidebar-text">By department</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        target="_blank"
                        href="#"
                    >
                        <span class="sidebar-text">By location</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li role="separator" class="dropdown-divider mt-4 mb-3 border-black"></li>

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
                <span class="sidebar-text">Offices</span>
            </span>
            <span class="link-arrow">
                <span class="fas fa-chevron-right"></span>
            </span>
        </span>
        <div
            class="multi-level collapse"
            role="list"
            id="submenu-offices"
            aria-expanded="false"
        >
            <ul class="flex-column nav">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        target="_blank"
                        href="#"
                    >
                        <span class="sidebar-text">Departments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        target="_blank"
                        href="#"
                    >
                        <span class="sidebar-text">Devices</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <span
            class="nav-link d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target="#submenu-employee"
        >
            <span>
                <span class="sidebar-icon">
                    <span class="fas fa-user-tie"></span>
                </span>
                <span class="sidebar-text">Peoples</span>
            </span>
            <span class="link-arrow">
                <span class="fas fa-chevron-right"></span>
            </span>
        </span>
        <div
            class="multi-level collapse  {{--Route::is('employees.*') ? 'show' : ''--}}"
            role="list"
            id="submenu-employee"
            aria-expanded="false"
        >
            <ul class="flex-column nav">
                <li class="nav-item {{--Route::is('employees.identities') ? 'active' : ''--}}">
                    <a
                        class="nav-link"
                        href="{{--route('employees.identities')--}}"
                    >
                        <span class="sidebar-text">THL</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li role="separator" class="dropdown-divider mt-4 mb-3 border-black"></li>
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
                <span class="sidebar-text">Users</span>
            </span>
            <span class="link-arrow">
                <span class="fas fa-chevron-right"></span>
            </span>
        </span>
        <div
            class="multi-level collapse {{--Route::is('users.*') ? 'show' : ''--}}"
            role="list"
            id="submenu-users"
            aria-expanded="false"
        >
            <ul class="flex-column nav">
                <li class="nav-item {{--Route::is('users.accounts') ? 'active' : ''--}}">
                    <a
                        class="nav-link"
                        href="{{-- route('users.accounts') --}}"
                    >
                        <span class="sidebar-text">Accounts</span>
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
                <span class="sidebar-text">Settings</span>
            </span>
            <span class="link-arrow">
                <span class="fas fa-chevron-right"></span>
            </span>
        </span>
        <div
            class="multi-level collapse  {{--Route::is('references.*') ? 'show' : ''--}}"
            role="list"
            id="submenu-setting"
            aria-expanded="false"
        >
            <ul class="flex-column nav">
                <li class="nav-item {{--Route::is('references.absent-types') ? 'active' : ''--}}">
                    <a
                        class="nav-link"
                        href="{{-- route('references.absent-types') --}}"
                    >
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item  {{--Route::is('references.work-times') ? 'active' : ''--}}">
                    <a
                        class="nav-link"
                        href="{{-- route('references.work-times') --}}"
                    >
                        <span class="sidebar-text">Mobile</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>


    <li role="separator" class="dropdown-divider mt-4 mb-3 border-black"></li>
    <li class="nav-item">
        <a
            href="#"
            target="_blank"
            class="nav-link d-flex align-items-center"
        >
            <span class="sidebar-icon">
                <span class="fas fa-book"></span>
            </span>
            <span class="sidebar-text">
                Documentation
                <span class="badge badge-md bg-secondary ms-1 text-dark">
                    v1.0
                </span>
            </span>
        </a>
    </li>
</ul>
