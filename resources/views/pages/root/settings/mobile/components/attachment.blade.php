<div class="card card-body shadow-sm table-wrapper table-responsive">
    <div class="mb-3 mb-lg-0">
        <div class="row">
            <div class="col-12 col-md-8">
                <h1 class="h4">Daftar lampiran</h1>
                <p>Daftar lampiran yang ditambahkan!</p>
            </div>
            <div class="col-12 col-md-4">
                <a
                    data-bs-toggle="modal"
                    data-bs-target="#addAttachmentModal"
                    class="btn btn-primary float-end"
                >Tambahkan lampiran baru</a>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Pratinjau</th>
            <th>Lokasi/Nama</th>
            <th>Tipe</th>
            <th>Pengunaan</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($attachments as $attachment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="width: 150px" class="text-center">
                    @if($attachment->type === 'LINK')
                        NONE
                    @else
                        <a
                            target="_blank"
                            href="{{asset('storage/uploads/'. $attachment->path.'/'.$attachment->name) }}"
                        >
                            <img
                                src="{{asset("storage/uploads/{$attachment->path}/{$attachment->name}")}}"
                                class="d-block w-100" alt="{{$attachment->name}}"
                            >
                        </a>
                    @endif
                </td>
                <td>
                    @if($attachment->type === 'LINK')
                        <b>name : {{$attachment->name}}</b> <br>
                        link : <a
                            target="_blank"
                            href="{{$attachment->path}}"
                            class="text-info"
                        >{{$attachment->path}}</a>
                    @else
                        <b>name: {{$attachment->name}}</b> <br>
                        lokasi : <a
                            target="_blank"
                            href="{{asset('storage/uploads/'. $attachment->path.'/'.$attachment->name) }}"
                            class="text-info"
                        >
                            {{$attachment->path}}
                        </a>
                    @endif

                </td>
                <td>{{$attachment->type}}</td>
                <td>
                    total penggunaan ({{
                        $attachment->mobile_preferences_count +
                        $attachment->submissions_count +
                        $attachment->attendances_count
                    }})
                    <br>presensi ({{$attachment->attendances_count}})
                    <br>lampiran ({{$attachment->submissions_count}})
                    <br>slider ({{$attachment->mobile_preferences_count}})
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
                                wire:click="selectedAttachment({{$attachment}}, 'UPDATE')"
                                class="dropdown-item">
                                <span class="fas fa-edit me-2"></span>
                                Perbaharui
                            </a>
                            <a
                                wire:click="selectedAttachment({{$attachment}}, 'DESTROY')"
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

    @if($attachments->count() <= 0)
        <div class="mt-4 text-center">
            Data tidak tersedia
        </div>
    @endif

    @include('components.delete-modal')
</div>
