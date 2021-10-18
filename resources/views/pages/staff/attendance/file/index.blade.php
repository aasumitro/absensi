@extends('layouts.main')

@section('title', "Import Excel File")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Presensi >> Import data</h1>
                <p class="mb-0">
                    Fitur ini digunakan untuk menambahkan data absensi secara masal.
                </p>
            </div>
        </div>

        @livewire('dash.staff.staff-attendance-excel-file')
    </section>
@endsection
