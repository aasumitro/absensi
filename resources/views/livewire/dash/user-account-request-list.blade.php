<div>
    <div class="card card-body shadow-sm table-wrapper table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Status</th>
                <th>Data</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($requests as $request)
                @php($user = json_decode($request->value))
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        REQ_AKUN_ADMIN <br>
                        <span class="badge bg-primary py-1 px-2">
						    {{department_data($user->department_id)->name}}
						</span>
                    </td>
                    <td>
                        <span class="badge bg-primary py-1 px-2">
						    {{
                                $request->status === 'EXIST'
                                ? "GANTI STATUS"
                                : "AKUN BARU"
                            }}
						</span>
                    </td>
                    <td>
                        Nama akun: {{$user->name}} <br>
                        Nama pengguna: {{$user->username}} <br>
                        Alamat email: {{$user->email}} <br>
                        Nomor ponsel: {{$user->phone}}
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
                                    wire:click="setSelectedAccount({{$request->value}}, '{{$request->id}}', '{{$request->commit_by}}', '{{$request->status}}', 'UPDATE')"
                                    class="dropdown-item">
                                    <span class="fas fa-edit me-2"></span>
                                    Perbaharui
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if($requests->count() <= 0)
            <div class="mt-4 text-center">
                Belum ada pengajuan baru
            </div>
        @endif

        <div class="mt-4 text-center">
            <nav class="d-inline-block text-center">
                <ul class="pagination mb-0">
                    {{ $requests->appends(request()->query())->links('components.pagination') }}
                </ul>
            </nav>
        </div>
    </div>

    @include('pages.root.users.submissions.components.edit-modal')
</div>


@section('custom-script')
    <script>
        let editRequestModal = document.getElementById('editUserAccountRequestModal')
        let bsEditRequestModal = new bootstrap.Modal(editRequestModal)

        window.addEventListener('openModal', event => {
            if (event.detail.type === 'UPDATE') {
                bsEditRequestModal.show()
            }
        })

        window.addEventListener('closeModal', event => {
            if (event.detail.type === 'UPDATE') {
                bsEditRequestModal.hide()
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
