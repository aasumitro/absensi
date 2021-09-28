@extends('layouts.main')

@section('title', "Department Setting")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Peganturan sistem</h1>
                <p class="mb-0">
                    Pengaturan sistem, baik absensi maupun zona waktu!
                </p>
            </div>
        </div>

        @livewire('dash.staff.staff-department-setting')
    </section>
@endsection
