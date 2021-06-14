<header class="navbar navbar-nav navbar-expand navbar-dark navbar-theme-primary">
    <div class="container px-3 px-md-4">
        <div class="d-flex align-items-center">
            <a
                class="navbar-brand me-4"
                href="#"
            >
                <img src="https://themesberg.com/docs/volt-bootstrap-5-dashboard/assets/brand/light.svg" height="30" alt="Volt logo">
            </a>
            <div class="navbar-nav-scroll order-md-0 justify-content-start d-none d-md-flex">
                <ul class="navbar-nav bd-navbar-nav flex-row">
                    @auth
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{route('home')}}"
                            >Home</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="#"
                        >FAQ's</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="#"
                        >Documentations</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownSupport" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Supports <i class="fas fa-angle-down nav-link-arrow ms-2"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownSupport">
                            <li>
                                <a
                                    href="#"
                                    target="_blank"
                                    class="dropdown-item"
                                >About</a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    target="_blank"
                                    class="dropdown-item"
                                >Contact Us</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <button class="btn btn-link bd-search-docs-toggle d-lg-none p-0 ms-3 order-3 ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#bd-docs-nav" aria-controls="bd-docs-nav" aria-expanded="false" aria-label="Toggle docs navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img"><title>Menu</title><path stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22" /></svg>
        </button>
        <div class="d-flex align-items-center">
            <div class="d-none d-lg-block">
                @auth
                    <span class="text-white">Hai, {{auth()->user()->username}}</span>
                @else
                    <a
                        class="btn btn-outline-white animate-up-2 ms-3 d-none d-sm-inline-block"
                        href="{{route('login')}}"
                    >Login</a>
                @endif
            </div>
        </div>
    </div>
</header>
