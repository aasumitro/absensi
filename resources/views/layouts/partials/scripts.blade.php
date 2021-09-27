<!-- core:js -->
<script src="{{ asset('assets/vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- end:core -->

<!-- plugins:js -->
<script src="{{ asset('assets/vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/nouislider/distribute/nouislider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chartist/dist/chartist.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
<!-- end:inject -->

<!-- inject:js -->
<script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor/notyf/notyf.min.js') }}"></script>
<!-- end:inject -->

<script src="{{ asset('assets/vendor/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/vendor/volt/dist/js/volt.js') }}"></script>

<script src="{{ asset('assets/js/notify.js') }}"></script>

@yield('custom-script')

@livewireScripts

{{--<script>--}}
{{--    window.onload = () => {--}}
{{--        alert('mohon gunakan browser terbaru, google chrome dan brave sangat disarankan')--}}
{{--    }--}}
{{--</script>--}}
