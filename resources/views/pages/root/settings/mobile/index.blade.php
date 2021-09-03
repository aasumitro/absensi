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
        let editPreferenceModal = document.getElementById('editSliderPreferencesModal')
        let bsEditPreferenceModal = new bootstrap.Modal(editPreferenceModal)

        window.addEventListener('openModal', event => {
            if (event.detail.type === "UPDATE") {
                bsEditPreferenceModal.show()
            }
        })

        window.addEventListener('closeModal', event => {
            if (event.detail.type === "UPDATE") {
                bsEditPreferenceModal.hide()
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
