<!-- plugins:css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/notyf/notyf.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/vanillajs-datepicker/dist/css/datepicker.min.css') }}"/>

<!-- endinject  -->

<!-- Layout styles -->
<link rel="stylesheet" href="{{ asset('assets/vendor/volt/dist/css/volt-pro.css') }}">
<!-- End layout styles -->

@yield('custom-style')

@livewireStyles
