<div>
    <div class="row mb-5">
        @include('pages.staff.admin.setting.components.widget')
        @include('pages.staff.admin.setting.components.timezone')
        @include('pages.staff.admin.setting.components.department')
    </div>
</div>

@section('custom-script')
    <script>
        let locale = `{{$department->timezone->locale}}`

        window.onload = () => {
            setInterval(initCurrentDatetime, 1000)
        }

        function initCurrentDatetime() {
            let currentDatetimeView = document
                .getElementById('currentDatetime')

            const today = new Date()

            const date = today.toLocaleDateString('id-ID', {
                year: "numeric",
                month: "long",
                day: "2-digit",
                timeZone: locale
            })

            const time = today.toLocaleTimeString('en-US', {
                formatMatcher: 'best fit',
                hour12: false,
                timeZone: locale
            })

            currentDatetimeView.innerHTML = [date, time].join(' - ')
        }

        window.addEventListener('showNotify', event => {
            showNotification(
                event.detail.type,
                event.detail.message
            )

            if (event.detail.type === 'success') {
                locale = event.detail.data
            }
        })
    </script>
@endsection
