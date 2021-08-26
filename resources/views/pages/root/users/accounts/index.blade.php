@extends('layouts.main')

@section('title', "System Settings")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">User account</h1>
                <p class="mb-0">
                    Add or modify user account with access dashboard privilege!
                </p>
            </div>

            <div class="btn-toolbar mb-2 mb-md-0">
                <button
                    data-bs-toggle="modal"
                    data-bs-target="#addUserModal"
                    type="button"
                    class="btn btn-dark h-75"
                >Create new Account</button>
            </div>
        </div>

        <div class="row col-12 p-3">
            @livewire('dash.user-account-list')
        </div>
    </section>
@endsection

@section('content-modal')
    @livewire('dash.user-account-create')
@endsection
