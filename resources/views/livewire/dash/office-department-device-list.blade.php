<div>
    <div class="card card-body shadow-sm table-wrapper table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>UUID</th>
                <th>Nama</th>
                <th>SKPD</th>
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
                    <td>
                         <span class="badge bg-primary py-1 px-2">
                             {{ $device->department->name }}
                         </span>
                    </td>
                    <td>{{ $device->refresh_time}} ({{ $device->refresh_time_mode}}) </td>
                    <td>
                        @if($device->display === 'DASHBOARD')
                            <a href="#" class="p-1" onclick="showNotification('error', 'Aksi untuk perangkat ini tidak dizinkan')">
                                <span class="fas fa-ban"></span>
                            </a>
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
                                    wire:click="selectedDevice({{$device}}, 'UPDATE')"
                                    href="#"
                                    class="dropdown-item"
                                >
                                    <span class="fas fa-edit me-2"></span>
                                    Perbaharui
                                </a>
                                <a
                                    href="#"
                                    wire:click="selectedDevice({{$device}}, 'DESTROY')"
                                    class="dropdown-item text-danger rounded-bottom"
                                >
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

    @include('pages.root.offices.device.components.add-modal')
    @include('pages.root.offices.device.components.edit-modal')
    @include('components.delete-modal')
</div>


@section('custom-script')
    <script>
        let addDeviceModal = document.getElementById('departmentAddDeviceModal')
        let bsAddDeviceModal = new bootstrap.Modal(addDeviceModal)
        let editDeviceModal = document.getElementById('departmentEditDeviceModal')
        let bsEditDeviceModal = new bootstrap.Modal(editDeviceModal)
        let deleteDeviceModal = document.getElementById('deleteModal')
        let bsDeleteDeviceModal = new bootstrap.Modal(deleteDeviceModal)

        window.addEventListener('openModal', event => {
            if (event.detail.type === "DESTROY") {
                bsDeleteDeviceModal.show()
            }

            if (event.detail.type === "UPDATE") {
                bsEditDeviceModal.show()
            }
        })

        window.addEventListener('closeModal', event => {
            if (event.detail.type === "DESTROY") {
                bsDeleteDeviceModal.hide()
            }

            if (event.detail.type === "CREATE") {
                bsAddDeviceModal.hide()
            }

            if (event.detail.type === "UPDATE") {
                bsEditDeviceModal.hide()
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
