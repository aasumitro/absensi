<div>
    <div class="card card-body shadow-sm table-wrapper table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Nama pengguna</th>
                <th>Alamat email</th>
                <th>Nomor ponsel</th>
                <th>Peran dan Hak</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($members as $account)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $account->user->name }}</td>
                    <td>{{ $account->user->username }}</td>
                    <td>{{ $account->user->email ?? "NOT_SET" }}</td>
                    <td>{{ "(+62) {$account->user->phone}" ?? "NOT_SET" }}</td>
                    <td>
                        @if($account->user->role_id === ROOT_ROLE_ID)
                            <span class="badge bg-primary py-1 px-2">
								    {{ "{$account->user->role->title} (Super Admin)" }}
							</span>
                        @else
                            <span class="badge bg-primary py-1 px-2">
								    {{
                                        $account->user->role->title === 'member'
                                        ? 'Pegawai'
                                        : ucfirst($account->user->role->title)
                                        . " pada " .
                                        $account->department->name
                                    }}
								</span>
                        @endif
                    </td>
                    <td>
                        @if($account->user->role->title === 'root')
                            <button
                                onclick="showNotification('error', 'Aksi untuk pengguna ini tidak diizinkan!')"
                                class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                            >
                                <span class="icon icon-sm">
                                    <span class="fas fa-ban icon-dark"></span>
                                </span>
                            </button>
                        @else
                        <div class="btn-group">
                            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="icon icon-sm">
                                        <span class="fas fa-ellipsis-h icon-dark"></span>
                                    </span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" data-popper-placement="bottom-end">
                                <a
                                    wire:click="selectedMemberAccount({{$account->user}}, 'RESET_PHONE')"
                                    class="dropdown-item">
                                    <span class="fas fa-mobile me-2"></span>
                                    Reset Akses Ponsel
                                </a>
                                <a
                                    wire:click="selectedMemberAccount({{$account->user}}, 'UPDATE')"
                                    class="dropdown-item">
                                    <span class="fas fa-edit me-2"></span>
                                    Perbaharui
                                </a>
                                <a
                                    wire:click="selectedMemberAccount({{$account->user}}, 'DESTROY')"
                                    class="dropdown-item text-danger rounded-bottom">
                                    <span class="fas fa-trash-alt me-2"></span>
                                    Hapus
                                </a>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if($members->count() <= 0)
            <div class="mt-4 text-center">
                Data tidak tersedia
            </div>
        @endif

        <div class="mt-4 text-center">
            <nav class="d-inline-block text-center">
                <ul class="pagination mb-0">
                    {{ $members->appends(request()->query())->links('components.pagination') }}
                </ul>
            </nav>
        </div>
    </div>

    @include('pages.staff.admin.people.components.add-modal')
    @include('pages.staff.admin.people.components.import-modal')
    @include('components.delete-modal')
</div>

@section('custom-script')
    <script>
        // let addDeviceModal = document.getElementById('addDepartmentDeviceModal')
        // let bsAddDeviceModalModal = new bootstrap.Modal(addDeviceModal)
        // let updateDeviceDataModal = document.getElementById('editDepartmentDeviceModal')
        // let bsUpdateDeviceDataModal = new bootstrap.Modal(updateDeviceDataModal)
        // let updateDevicePasswordModal = document.getElementById('updateDevicePasswordModal')
        // let bsUpdateDevicePasswordModal = new bootstrap.Modal(updateDevicePasswordModal)
        // let deleteDeviceModal = document.getElementById('deleteModal')
        // let bsDeleteDeviceModal = new bootstrap.Modal(deleteDeviceModal)
        // let detailDeviceModal = document.getElementById('detailDepartmentDeviceModal')
        // let bsDetailDeviceActivityModal = new bootstrap.Modal(detailDeviceModal)

        window.addEventListener('openModal', event => {
            // if (event.detail.type === "DESTROY") {
            //     bsDeleteDeviceModal.show()
            // }

            // if (event.detail.type === "UPDATE") {
            //     bsUpdateDeviceDataModal.show()
            // }

            // if (event.detail.type === "UPDATE_PASSWORD") {
            //     bsUpdateDevicePasswordModal.show()
            // }

            // if (event.detail.type === "DETAIL") {
            //     console.log('test')
            //     bsDetailDeviceActivityModal.show()
            // }
        })

        window.addEventListener('closeModal', event => {
            // if (event.detail.type === "DESTROY") {
            //     bsDeleteDeviceModal.hide()
            // }

            // if (event.detail.type === "CREATE") {
            //     bsAddDeviceModalModal.hide()
            // }

            // if (event.detail.type === "UPDATE") {
            //     bsUpdateDeviceDataModal.hide()
            // }

            // if (event.detail.type === "UPDATE_PASSWORD") {
            //     bsUpdateDevicePasswordModal.hide()
            // }
        })

        window.addEventListener('showNotify', event => {
            showNotification(
                event.detail.type,
                event.detail.message
            )
        })

        // function obscureSecretText() {
        //     let passwordInput = document.getElementById("password");
        //     let passwordObscureIcon = document.getElementById("password_obscure_icon");
        //
        //     if (passwordInput.type === "password") {
        //         passwordInput.type = "text";
        //         passwordObscureIcon.classList.remove('fa-eye')
        //         passwordObscureIcon.classList.add('fa-eye-slash')
        //     } else {
        //         passwordInput.type = "password";
        //         passwordObscureIcon.classList.remove('fa-eye-slash')
        //         passwordObscureIcon.classList.add('fa-eye')
        //     }
        // }
    </script>
@endsection
