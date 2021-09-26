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
                @foreach($users as $account)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->username }}</td>
                        <td>{{ $account->email ?? "NOT_SET" }}</td>
                        <td>{{ "(+62) $account->phone" ?? "NOT_SET" }}</td>
                        <td>
                            @if($account->role_id === ROOT_ROLE_ID)
                                <span class="badge bg-primary py-1 px-2">
								    {{ "{$account->role->title} (Super Admin)" }}
								</span>
                            @else
                                <span class="badge bg-primary py-1 px-2">
								    {{
                                        $account->role->title
                                        . " pada " .
                                        $account->profile->department->name
                                    }}
								</span>
                            @endif
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
                                    <a
                                        wire:click="selectedAccount({{$account}}, 'UPDATE')"
                                        class="dropdown-item">
                                        <span class="fas fa-edit me-2"></span>
                                        Perbaharui
                                    </a>
                                    <a
                                        wire:click="selectedAccount({{$account}}, 'DESTROY')"
                                        class="dropdown-item text-danger rounded-bottom">
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

        @if($users->count() <= 0)
            <div class="mt-4 text-center">
                Data tidak tersedia
            </div>
        @endif

        <div class="mt-4 text-center">
            <nav class="d-inline-block text-center">
                <ul class="pagination mb-0">
                    {{ $users->appends(request()->query())->links('components.pagination') }}
                </ul>
            </nav>
        </div>
    </div>

    @include('pages.root.users.accounts.components.edit-modal')
    @include('components.delete-modal')
</div>
