<div class="pb-5">
    <div class="card shadow-sm table-wrapper table-responsive">
        @include('pages.staff.report.dates.components.filters')
        @include('pages.staff.report.dates.components.table')
    </div>
</div>


@section('custom-script')
    <script>
        window.addEventListener('showNotify', event => {
            showNotification(
                event.detail.type,
                event.detail.message,
                5000
            )
        })
    </script>
@endsection
