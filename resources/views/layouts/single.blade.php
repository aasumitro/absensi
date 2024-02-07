<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.meta')

        <title>@yield('title') | Absensi</title>

        @include('layouts.partials.styles')

        <link
            rel="stylesheet"
            href="{{ asset('assets/vendor/volt/dist/css/docs.css') }}"
        >
    </head>
    <body>
        @include('layouts.partials.toolbar')
        <div class="container my-4">
            <div class="row flex-xl-nowrap">
                @yield('content')
            </div>
        </div>

        @include('layouts.partials.scripts')
    </body>
</html>
