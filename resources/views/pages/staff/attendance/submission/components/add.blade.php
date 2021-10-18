<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="addNewSubmission"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performAddSubmission">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat pengajuan baru</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user" class="form-label">Cari pegawai</label>
                        <input
                            type="text"
                            id="user"
                            class="form-control"
                            placeholder="kata kunci (nama pegawai) . . ."
                            wire:model="query"
                        />
                    </div>

                    <div wire:loading class="text-center">
                        <div class="list-item">Searching...</div>
                    </div>

                    @if(!empty($query))
                        <div class="fw-bold">Pilih salah satu:</div>
                        <div class="list-group border-3 mb-3">
                            @if($users->count() > 0)
                                @foreach($users as $i => $user)
                                    <a
                                        href="#"
                                        wire:click="selectUser({{$user}})"
                                        class="list-group-item list-group-item-action fw-bold"
                                    >
                                        {{ $user['name'] }}
                                    </a>
                                @endforeach
                            @else
                                <a class="list-group-item list-group-item-action disabled">
                                    No results!
                                </a>
                            @endif
                        </div>
                    @endif

                    @if($selected_user)
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>Nama </td>
                                <td>{{optional($selected_user)->name}}</td>
                            </tr>
                            <tr>
                                <td>SKPD </td>
                                <td>{{optional($selected_user->profile->department)->name}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="form-group mb-4">
                            <label for="absent_type">Silahkan pilih tipe izin</label>
                            <div class="input-group">
                            <span class="input-group-text" id="update_status_icon">
                                <span class="fas fa-tags"></span>
                            </span>
                                <select
                                    id="absent_type"
                                    class="form-control @error('absent_type') is-invalid @enderror"
                                    wire:model="absent_type"
                                    required
                                >
                                    @foreach($absentTypes as $type)
                                        <option value="{{$type->id}}">
                                            {{strtoupper($type->description)}} ({{$type->name}})
                                        </option>
                                    @endforeach
                                </select>

                                @error('absent_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="title">Judul</label>
                            <div class="input-group">
                                <span class="input-group-text" id="update_notes_icon">
                                    <span class="fas fa-sticky-note"></span>
                                </span>
                                <input
                                    type="text"
                                    wire:model="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    autofocus
                                    required
                                />
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="description">Deskripsi</label>
                            <div class="input-group">
                                <span class="input-group-text" id="update_notes_icon">
                                    <span class="fas fa-sticky-note"></span>
                                </span>
                                <textarea
                                    wire:model="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    id="description"
                                    rows="2"
                                    autofocus
                                    required
                                ></textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="date_start" class="form-label">Tanggal Mulai</label>
                                    <input
                                        type="date"
                                        name="date_start"
                                        id="date_start"
                                        data-date-format="DD-MMMM-YYYY"
                                        class="form-control  @error('date_start') is-invalid @enderror"
                                        wire:model="date_start"
                                    />
                                    @error('date_start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="date_end" class="form-label">Tanggal Selesai</label>
                                    <input
                                        type="date"
                                        name="date_end"
                                        id="date_end"
                                        data-date-format="DD-MMMM-YYYY"
                                        class="form-control  @error('date_end') is-invalid @enderror"
                                        wire:model="date_end"
                                    />
                                    @error('date_end')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="formFile" class="form-label">File lampiran (pdf, jpg, png, jpeg)</label>
                            <input
                                class="form-control  @error('file') is-invalid @enderror"
                                type="file"
                                id="formFile"
                                wire:model="file"
                            >
                            @error('file')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-dark"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>
                    <button
                        wire:click="performAddSubmission"
                        type="submit"
                        class="btn btn-danger"
                    >
                        Buat
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
