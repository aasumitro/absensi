<div>
    <div class="card card-body shadow-sm table-wrapper table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th rowspan="2">#</th>
                <th rowspan="2">Nama</th>
                <th colspan="2" class="text-center">Jam</th>
                <th colspan="2" class="text-center">Sesi Absensi</th>
                <th colspan="2" class="text-center">Total Data</th>
                <th rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th>Masuk</th>
                <th>Keluar</th>
                <th class="text-center">Buka</th>
                <th class="text-center">Tutup</th>
                <th>perangkat</th>
                <th>pegawai</th>
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
                        {{ $department->min_att_acc}} MENIT
                        @php($now = \Carbon\Carbon::now($department->timezone->locale)->format('Y-m-d'))
                        / PUKUL {{
                            \Carbon\Carbon::createFromDate("$now $department->max_att_in")
                            ->subMinutes((int)$department->min_att_acc)
                            ->format('H:i')
                        }}
                    </td>
                    <td>
                        {{ $department->max_att_acc}} MENIT
                        / PUKUL {{
                            \Carbon\Carbon::createFromDate("$now $department->max_att_in")
                            ->addMinutes((int)$department->max_att_acc)
                            ->format('H:i')
                        }}
                    </td>
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
                                <a href="#" wire:click="selectedDepartment({{$department}}, 'UPDATE')" class="dropdown-item">
                                    <span class="fas fa-edit me-2"></span>
                                    Perbaharui
                                </a>
                                <a href="#" wire:click="selectedDepartment({{$department}}, 'DESTROY')" class="dropdown-item text-danger rounded-bottom">
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

        <div class="mt-4 text-center">
            <nav class="d-inline-block text-center">
                <ul class="pagination mb-0">
                    {{ $departments->appends(request()->query())->links('components.pagination') }}
                </ul>
            </nav>
        </div>

        @if($departments->count() <= 0)
            <div class="mt-4 text-center">
                Data tidak tersedia
            </div>
        @else
            <div class="mt-4 ">
                <h5>Keterangan:</h5>
                <p>
                    1. Diatas jam masuk dihitung <code>TERLAMBAT</code>. <br>
                    2. Buka sesi absensi dihitung dari (<code>JAM_MASUK - SESI_ABSENSI_BUKA</code>). <br>
                    3. Tutup sesi absensi dihitung dari (<code>JAM_MASUK + SESI_ABSENSI_TUTUP</code>)
                </p>
            </div>
        @endif
    </div>

    @include('pages.root.offices.department.components.add-modal')
    @include('pages.root.offices.department.components.edit-modal')
    @include('components.delete-modal')
</div>

@section('custom-script')
    <script>
        let addDepartmentModal = document.getElementById('departmentAddModal')
        let bsAddDepartmentModal = new bootstrap.Modal(addDepartmentModal)
        let editDepartmentModal = document.getElementById('departmentEditModal')
        let bsEditDepartmentModal = new bootstrap.Modal(editDepartmentModal)
        let deleteDepartmentModal = document.getElementById('deleteModal')
        let bsDeleteDepartmentModal = new bootstrap.Modal(deleteDepartmentModal)

        window.addEventListener('openModal', event => {
            if (event.detail.type === "DESTROY") {
                bsDeleteDepartmentModal.show()
            }

            if (event.detail.type === "UPDATE") {
                bsEditDepartmentModal.show()
            }
        })

        window.addEventListener('closeModal', event => {
            if (event.detail.type === "DESTROY") {
                bsDeleteDepartmentModal.hide()
            }

            if (event.detail.type === "CREATE") {
                bsAddDepartmentModal.hide()
            }

            if (event.detail.type === "UPDATE") {
                bsEditDepartmentModal.hide()
            }
        })

        window.addEventListener('showNotify', event => {
            showNotification(
                event.detail.type,
                event.detail.message
            )
        })
    </script>
@endsection
