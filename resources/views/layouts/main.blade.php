<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.meta')

        <title>@yield('title') | e-Office by Cleverlabs</title>

        @include('layouts.partials.styles')
    </head>
    <body>
        @include('layouts.partials.navigation')

        @include('layouts.partials.sidebar')

        <main class="content">
            @include('layouts.partials.navbar')

            @yield('module')
        </main>
        @include('layouts.partials.footer')

        @yield('content-modal')

        @include('components.logout')

        @include('layouts.partials.scripts')
    </body>
</html>
