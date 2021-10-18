@extends('layouts.main')

@section('title', "By Date Range Report")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Laporan >> Berdasarkan Tanggal</h1>
                <p class="mb-0">
                    Fitur ini digunakan untuk melihat laporan presensi berdasarkan tanggal.
                </p>
            </div>
        </div>

        @livewire('dash.staff.staff-report-by-dates')
    </section>
@endsection
