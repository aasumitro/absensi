<div>
    @include('pages.staff.attendance.submission.components.counting')

    <div class="card shadow-sm table-wrapper table-responsive">
        @include('pages.staff.attendance.submission.components.filter')
        @include('pages.staff.attendance.submission.components.list')
    </div>

    @include('pages.staff.attendance.submission.components.add')
    @include('pages.staff.attendance.submission.components.update')
</div>

@section('custom-script')
    <script>
        let addSubmission = document.getElementById('addNewSubmission')
        let bsAddSubmissionModal = new bootstrap.Modal(addSubmission)
        let editSubmission = document.getElementById('editSubmission')
        let bsEditSubmissionModal = new bootstrap.Modal(editSubmission)

        window.addEventListener('openModal', event => {
            if (event.detail.type === "UPDATE") {
                bsEditSubmissionModal.show()
            }
        })

        window.addEventListener('closeModal', event => {
            if (event.detail.type === "UPDATE") {
                bsEditSubmissionModal.hide()
            }

            if (event.detail.type === "CREATE") {
                bsAddSubmissionModal.hide()
            }
        })

        window.addEventListener('showNotify', event => {
            showNotification(
                event.detail.type,
                event.detail.message,
                7000
            )
        })
    </script>
@endsection
