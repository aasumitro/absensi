@extends('layouts.main')

@section('title', "Manual Input")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Presensi >> Input manual</h1>
                <p class="mb-0">
                    Tambahakan data presensi baru berdasarkan data pengguna!
                </p>
            </div>
        </div>

        @livewire('dash.staff.staff-attendance-manual-input')
    </section>
{{--    input manual one by one by selected id or credentials--}}
{{--    // search user--}}
{{--    // display public data--}}
{{--    // show selection (ATTEND/ABSENT)--}}
{{--    // if absent show absent type select--}}
{{--    // select date--}}
{{--    // select time in/out--}}
{{--    // select overdue (YES/NO)--}}
{{--    // select overtime (YES/NO)--}}
{{--    // set by ADMIN/OPERATOR--}}
@endsection
