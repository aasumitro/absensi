@extends('layouts.main')

@section('title', "Verify Submission")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Verifikasi pengajuan</h1>
                <p class="mb-0">
                    verifikasi pengajuan yang dibuat pengguna.
                </p>
            </div>

            <div class="btn-toolbar mb-2 mb-md-0">
                <button
                    data-bs-toggle="modal"
                    data-bs-target="#addNewSubmission"
                    type="button"
                    class="btn btn-dark h-75"
                >Buat pengajuan baru</button>
            </div>
        </div>

        @livewire('dash.staff.staff-attendance-verify-submission')
    </section>
@endsection
