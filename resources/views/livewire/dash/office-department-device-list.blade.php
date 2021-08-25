<div>
    <div class="card card-body shadow-sm table-wrapper table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>UUID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Refresh Time</th>
                <th>Action</th>
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
                                    Edit
                                </a>
                                <a href="#"  class="dropdown-item text-danger rounded-bottom">
                                    <span class="fas fa-trash-alt me-2"></span>
                                    Remove
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if($devices->count() <= 0)
            <div class="mt-4 text-center">
                No data available
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
</div>
