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
                        @if($device->display === 'DASHBOARD')
                            <button
                                onclick="showNotification('error', 'Aksi untuk perangkat ini tidak diizinkan!')"
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
                                        wire:click="selectedDepartmentDevice({{$device}}, 'UPDATE')"
                                        class="dropdown-item"
                                    >
                                        <span class="fas fa-edit me-2"></span>
                                        Data umum (Edit)
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
                                </div>
                            </div>
                        @endif
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
        })

        window.addEventListener('showNotify', event => {
            if (event.detail.data) {
                prompt("UUID perangkat baru, Copy data: Ctrl+C, Enter", event.detail.data);
            }

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