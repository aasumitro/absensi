@extends('layouts.main')

@section('title', "Requests Account")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Permintaan akun admin pengguna</h1>
                <p class="mb-0">
                    Pengajuan/Permintaan penambahan akun admin untuk masing-masing SKPD!
                </p>
            </div>
        </div>

        <div class="row col-12 p-3">
            @livewire('dash.root.user-account-request-list')
        </div>
    </section>
@endsection
