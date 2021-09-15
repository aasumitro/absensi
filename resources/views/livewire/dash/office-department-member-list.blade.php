<div>
    <div class="card card-body shadow-sm table-wrapper table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Department</th>
                <th>UUID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                         <span class="badge bg-primary py-1 px-2">
                             {{ $member->department->name }}
                         </span>
                    </td>
                    <td>{{ $member->user->unique_id }}</td>
                    <td>{{ $member->user->name }}</td>
                    <td>{{ $member->user->email }}</td>
                    <td>(+62) {{ $member->user->phone }}</td>
                    <td>{{ $member->user->status }}</td>
                    <td>
                        @if(auth()->user()->hasRole('root'))
                            <div class="btn-group">
                                <button
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="true"
                                    class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                >
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
                        @else
                            <button
                                class="btn btn-link text-dark m-0 p-0"
                                onclick="showNotification('error', 'Action restricted this user has high level access!')"
                            >
                                <span class="icon icon-sm">
                                    <span class="fas fa-ban icon-dark"></span>
                                </span>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if($members->count() <= 0)
            <div class="mt-4 text-center">
                No data available
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
</div>
