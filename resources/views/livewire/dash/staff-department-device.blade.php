<div>
    <div class="card card-body shadow-sm table-wrapper table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>UUID</th>
                <th>Nama</th>
                <th>Waktu Refresh</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($devices as $device)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $device->unique_id }}</td>
                    <td>{{ $device->name }} - {{ $device->display }}</td>
                    <td>{{ $device->refresh_time}} ({{ $device->refresh_time_mode}}) </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="icon icon-sm">
                                        <span class="fas fa-ellipsis-h icon-dark"></span>
                                    </span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" data-popper-placement="bottom-end">
                                <a
                                    wire:click="selectedDepartmentDevice({{$device}}, 'DETAIL')"
                                    class="dropdown-item"
                                >
                                    <span class="fas fa-info me-2"></span>
                                    Data detail
                                </a>
                                @if($device->display !== 'DASHBOARD')
                                    <a
                                        wire:click="selectedDepartmentDevice({{$device}}, 'UPDATE')"
                                        class="dropdown-item"
                                    >
                                        <span class="fas fa-edit me-2"></span>
                                        Data umum (Edit)
                                    </a>
                                    <a
                                        wire:click="selectedDepartmentDevice({{$device}}, 'RESET')"
                                        class="dropdown-item"
                                    >
                                        <span class="fas fa-microchip me-2"></span>
                                        Reset Perangkat
                                    </a>
                                    <a
                                        wire:click="selectedDepartmentDevice({{$device}}, 'UPDATE_PASSWORD')"
                                        class="dropdown-item"
                                    >
                                        <span class="fas fa-key me-2"></span>
                                        Kata sandi (Edit)
                                    </a>
                                    <a
                                        wire:click="selectedDepartmentDevice({{$device}}, 'DESTROY')"
                                        class="dropdown-item text-danger rounded-bottom">
                                        <span class="fas fa-trash-alt me-2"></span>
                                        Hapus
                                    </a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if($devices->count() <= 0)
            <div class="mt-4 text-center">
                Data tidak tersedia
            </div>
        @endif

        <div class="mt-4 text-center">
            <nav class="d-inline-block text-center">
                <ul class="pagination mb-0">
                    {{ $devices->appends(request()->query())->links('components.pagination') }}
                </ul>
            </nav>
        </div>
    </div>

    @include('pages.staff.admin.device.components.add-modal')
    @include('pages.staff.admin.device.components.edit-modal')
    @include('pages.staff.admin.device.components.edit-password-modal')
    @include('pages.staff.admin.device.components.detail-modal')
    @include('pages.staff.admin.device.components.reset-modal')
    @include('components.delete-modal')
</div>

@section('custom-script')
    <script>
        let addDeviceModal = document.getElementById('addDepartmentDeviceModal')
        let bsAddDeviceModalModal = new bootstrap.Modal(addDeviceModal)
        let updateDeviceDataModal = document.getElementById('editDepartmentDeviceModal')
        let bsUpdateDeviceDataModal = new bootstrap.Modal(updateDeviceDataModal)
        let updateDevicePasswordModal = document.getElementById('updateDevicePasswordModal')
        let bsUpdateDevicePasswordModal = new bootstrap.Modal(updateDevicePasswordModal)
        let deleteDeviceModal = document.getElementById('deleteModal')
        let bsDeleteDeviceModal = new bootstrap.Modal(deleteDeviceModal)
        let detailDeviceModal = document.getElementById('detailDepartmentDeviceModal')
        let bsDetailDeviceActivityModal = new bootstrap.Modal(detailDeviceModal)
        let resetDeviceModal = document.getElementById('resetModal')
        let bsResetDeviceModal = new bootstrap.Modal(resetDeviceModal)

        window.addEventListener('openModal', event => {
            if (event.detail.type === "DESTROY") {
                bsDeleteDeviceModal.show()
            }

            if (event.detail.type === "UPDATE") {
                bsUpdateDeviceDataModal.show()
            }

            if (event.detail.type === "UPDATE_PASSWORD") {
                bsUpdateDevicePasswordModal.show()
            }

            if (event.detail.type === "DETAIL") {
                bsDetailDeviceActivityModal.show()
            }

            if (event.detail.type === 'RESET') {
                bsResetDeviceModal.show()
            }
         })

        window.addEventListener('closeModal', event => {
            if (event.detail.type === "DESTROY") {
                bsDeleteDeviceModal.hide()
            }

            if (event.detail.type === "CREATE") {
                bsAddDeviceModalModal.hide()
            }

            if (event.detail.type === "UPDATE") {
                bsUpdateDeviceDataModal.hide()
            }

            if (event.detail.type === "UPDATE_PASSWORD") {
                bsUpdateDevicePasswordModal.hide()
            }

            if (event.detail.type === 'RESET') {
                bsResetDeviceModal.hide()
            }
        })

        window.addEventListener('showNotify', event => {
            showNotification(
                event.detail.type,
                event.detail.message
            )
        })

        function obscureSecretText() {
            let passwordInput = document.getElementById("password");
            let passwordObscureIcon = document.getElementById("password_obscure_icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordObscureIcon.classList.remove('fa-eye')
                passwordObscureIcon.classList.add('fa-eye-slash')
            } else {
                passwordInput.type = "password";
                passwordObscureIcon.classList.remove('fa-eye-slash')
                passwordObscureIcon.classList.add('fa-eye')
            }
        }
    </script>
@endsection
