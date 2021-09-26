@extends('layouts.main')

@section('title', "Home")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Kantor >> SKPD</h1>
                <p class="mb-0">
                    Tambah atau perbaharui data SKPD!
                </p>
            </div>

            <div class="btn-toolbar mb-2 mb-md-0">
                <button
                    data-bs-toggle="modal"
                    data-bs-target="#add-patient"
                    type="button"
                    class="btn btn-dark h-75"
                >Tambah SKPD baru</button>
            </div>
        </div>

        <div class="row col-12 p-3">
            @livewire('dash.office-department-list')
        </div>
    </section>
@endsection
