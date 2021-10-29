<div>
    <div class="card card-body shadow-sm table-wrapper table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>SKPD</th>
                <th>UUID</th>
                <th>Nama</th>
                <th>Alamat Email</th>
                <th>Nomor Ponsel</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($members as $member)
                <tr>
                    <td>
                        {{ ($members->currentPage()-1) * $members->perPage() + $loop->index + 1 }}
                    </td>
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
                                    <a
                                        wire:click="selectedMember({{$member}}, 'UPDATE')"
                                        class="dropdown-item">
                                        <span class="fas fa-edit me-2"></span>
                                        Perbaharui
                                    </a>
                                    <a
                                        wire:click="selectedMember({{$member}}, 'DESTROY')"
                                        class="dropdown-item text-danger rounded-bottom">
                                        <span class="fas fa-trash-alt me-2"></span>
                                        Hapus
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

    @include('pages.root.offices.people.components.add-modal')
    @include('pages.root.offices.people.components.edit-modal')
    @include('components.delete-modal')
</div>

@section('custom-script')
    <script>
        let addMemberModal = document.getElementById('departmentAddMemberModal')
        let bsAddMemberModal = new bootstrap.Modal(addMemberModal)
        let editMemberModal = document.getElementById('departmentEditMemberModal')
        let bsEditMemberModal = new bootstrap.Modal(editMemberModal)
        let deleteUserModal = document.getElementById('deleteModal')
        let bsDeleteUserModal = new bootstrap.Modal(deleteUserModal)

        window.addEventListener('openModal', event => {
            if (event.detail.type === "DESTROY") {
                bsDeleteUserModal.show()
            }

            if (event.detail.type === "UPDATE") {
                bsEditMemberModal.show()
            }
        })

        window.addEventListener('closeModal', event => {
            if (event.detail.type === "DESTROY") {
                bsDeleteUserModal.hide()
            }

            if (event.detail.type === "CREATE") {
                bsAddMemberModal.hide()
            }

            if (event.detail.type === "UPDATE") {
                bsEditMemberModal.hide()
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
