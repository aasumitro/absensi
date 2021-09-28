@extends('layouts.main')

@section('title', "Department Staff")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Kantor >> Pegawai SKPD</h1>
                <p class="mb-0">
                    Tambah atau perbaharui data pegawai SKPD!
                </p>
            </div>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="dropdown me-1">
                    <button
                        type="button"
                        class="btn btn-primary dropdown-toggle show"
                        id="dropdownMenuOffset"
                        data-bs-toggle="dropdown"
                        aria-expanded="true"
                        data-bs-offset="10,20"
                    >Tambah pegawai baru</button>
                    <ul
                        class="dropdown-menu py-0"
                        aria-labelledby="dropdownMenuOffset"
                        data-popper-placement="bottom-start"
                    >
                        <li>
                            <a class="dropdown-item rounded-top" href="#">
                                Input manual
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                Import file excel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row col-12 p-3">
            @livewire('dash.staff.staff-department-member')
        </div>
    </section>
@endsection
