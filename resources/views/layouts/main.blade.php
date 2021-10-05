<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.meta')

        <title>@yield('title') | OkSetda Absensi</title>

        @include('layouts.partials.styles')
    </head>
    <body>
        @include('layouts.partials.navigation')

        @include('layouts.partials.sidebar')

        <main class="content">
            @include('layouts.partials.navbar')

            @yield('content')
        </main>
        @include('layouts.partials.footer')

        @yield('content-modal')

        @include('components.logout')

        @include('components.recommended-browser-modal')

        @include('layouts.partials.scripts')

        <script>
            window.onload = () => {
                let isRecommendedBrowserDisplayed = localStorage.getItem('recommended_browser_display') ?? "DISPLAY"
                if (isRecommendedBrowserDisplayed === 'DISPLAY') {
                    let recommendedBrowserModal = document.getElementById('recommendedBrowserModal')
                    let bsRecommendedBrowserModal = new bootstrap.Modal(recommendedBrowserModal)
                    bsRecommendedBrowserModal.show()
                }
            }
        </script>
    </body>
</html>
