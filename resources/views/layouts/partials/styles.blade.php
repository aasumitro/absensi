<!-- plugins:css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/notyf/notyf.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/vanillajs-datepicker/dist/css/datepicker.min.css') }}"/>

<!-- endinject  -->

<!-- Layout styles -->
<link rel="stylesheet" href="{{ asset('assets/vendor/volt/dist/css/volt-pro.css') }}">
<!-- End layout styles -->

<style>
    .loader{
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('{{asset('/assets/img/loading.gif')}}')
        50% 50% no-repeat rgb(0,0,0, 0.5);
    }
</style>

@yield('custom-style')

@livewireStyles
