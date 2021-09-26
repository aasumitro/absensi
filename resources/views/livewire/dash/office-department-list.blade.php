<div>
    <div class="card card-body shadow-sm table-wrapper table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Perangkat</th>
                <th>Pegawai</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->max_att_in }}</td>
                    <td>{{ $department->min_att_out}}</td>
                    <td>
                         <span class="badge bg-primary py-1 px-2">
                             {{ $department->devices_count }}
                         </span>
                    </td>
                    <td>
                         <span class="badge bg-primary py-1 px-2">
                             {{ $department->members_count }}
                         </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="icon icon-sm">
                                        <span class="fas fa-ellipsis-h icon-dark"></span>
                                    </span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" data-popper-placement="bottom-end">
                                <a href="#" class="dropdown-item">
                                    <span class="fas fa-edit me-2"></span>
                                    Perbaharui
                                </a>
                                <a href="#"  class="dropdown-item text-danger rounded-bottom">
                                    <span class="fas fa-trash-alt me-2"></span>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if($departments->count() <= 0)
            <div class="mt-4 text-center">
                Data tidak tersedia
            </div>
        @endif

        <div class="mt-4 text-center">
            <nav class="d-inline-block text-center">
                <ul class="pagination mb-0">
                    {{ $departments->appends(request()->query())->links('components.pagination') }}
                </ul>
            </nav>
        </div>
    </div>
</div>
