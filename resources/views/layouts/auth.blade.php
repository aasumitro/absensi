<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.meta')

        <title>@yield('title') | OkSetda Absensi</title>

        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <!-- endinject  -->

        <!-- Layout styles -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/volt/dist/css/volt.css') }}">
        <!-- End layout styles -->

        @yield('custom-style')

        @livewireStyles
    </head>
    <body>
        <section class="d-flex align-items-center my-5 mt-lg-6 mb-lg-5">
            <div class="container">
                @yield('content')
            </div>
        </section>

        <!-- core:js -->
        <script src="{{ asset('assets/vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- end:core -->

        @yield('custom-script')

        @livewireScripts
    </body>
</html>
