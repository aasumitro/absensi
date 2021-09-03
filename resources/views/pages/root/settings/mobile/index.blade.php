@extends('layouts.main')

@section('title', "Mobile Settings")

@section('content')
    <section class="mb-3">
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Mobile Apps</h1>
                <p class="mb-0">
                    Settings and References like sliders, announcement and others!
                </p>
            </div>
        </div>

        @livewire('dash.setting-mobile-slider')
    </section>
@endsection

@section('custom-script')
    <script>
        let addAttachmentModal = document.getElementById('addAttachmentModal')
        let bsAddAttachmentModal = new bootstrap.Modal(addAttachmentModal)
        let editPreferenceModal = document.getElementById('editSliderPreferencesModal')
        let bsEditPreferenceModal = new bootstrap.Modal(editPreferenceModal)
        let editAttachmentModal = document.getElementById('editAttachmentModal')
        let bsEditAttachmentModal = new bootstrap.Modal(editAttachmentModal)
        let deleteModal = document.getElementById('deleteModal')
        let bsDeleteModal = new bootstrap.Modal(deleteModal)

        window.addEventListener('openModal', event => {
            if (event.detail.action === 'DESTROY') {
                bsDeleteModal.show()
            }

            if (event.detail.action === "UPDATE" && event.detail.type !== 'ATTACHMENT') {
                bsEditPreferenceModal.show()
            }

            if (event.detail.action === "UPDATE" && event.detail.type === 'ATTACHMENT') {
                bsEditAttachmentModal.show()
            }
        })

        window.addEventListener('closeModal', event => {
            if (event.detail.action === 'DESTROY') {
                bsDeleteModal.hide()
            }

            if (event.detail.action === "UPDATE" && event.detail.type !== 'ATTACHMENT') {
                bsEditPreferenceModal.hide()
            }

            if (event.detail.action === "UPDATE" && event.detail.type === 'ATTACHMENT') {
                bsEditAttachmentModal.hide()
            }

            if (event.detail.action === 'CREATE') {
                bsAddAttachmentModal.hide()
            }
        })

        window.addEventListener('showNotify', event => {
            showNotification(
                event.detail.type,
                event.detail.message
            )
        })
    </script>
@endsection
