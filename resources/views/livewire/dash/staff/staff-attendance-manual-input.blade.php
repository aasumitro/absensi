<div>
    <div class="row">
        <div class="col-12 col-md-4 mb-sm-3">
            <div class="card card-body shadow-sm">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Data Pegawai</h1>
                    <p>Data pegawai secara detail akan ditampilkan ketika salah satu pegawai dipilih!</p>
                </div>
                <div class="mb-3">
                    <label for="user" class="form-label">Cari pegawai</label>
                    <input
                        type="text"
                        id="user"
                        class="form-control"
                        placeholder="kata kunci . . ."
                        wire:model="query"
                    />
                </div>

                <div wire:loading class="text-center">
                    <div class="list-item">Searching...</div>
                </div>

                @if(!empty($query))
                    <div class="list-group border-3 mb-3">
                        @if($users->count() > 1)
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
                        <td>Nama pengguna </td>
                        <td>{{'@'.optional($selected_user)->username}}</td>
                    </tr>
                    <tr>
                        <td>Alamat email </td>
                        <td>{{optional($selected_user)->email}}</td>
                    </tr>
                    <tr>
                        <td>Nomor ponsel </td>
                        <td>(+62){{optional($selected_user)->phone}}</td>
                    </tr>
                    <tr>
                        <td>SKPD </td>
                        <td>{{optional($selected_user->profile->department)->name}}</td>
                    </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>

        <div class="col-12 col-md-8 mb-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3 mb-lg-0">
                        <h1 class="h4">Form Presensi {{ $selected_user ? "untuk $selected_user->name" : ''}}</h1>
                        <p>Sebelum melakukan aksi simpan, silahkan pastikan kembali formulir yang diisi!</p>
                    </div>
                    @if($selected_user)
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input
                                type="date"
                                name="date"
                                id="date"
                                data-date-format="DD-MMMM-YYYY"
                                class="form-control  @error('date') is-invalid @enderror"
                                wire:model="date"
                            />
                            @error('date')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="time_in" class="form-label">Jam Datang</label>
                                    <input
                                        type="time"
                                        name="time_in"
                                        id="time_in"
                                        class="form-control  @error('time_in') is-invalid @enderror"
                                        wire:model="time_in"
                                    />
                                    @error('time_in')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="time_out" class="form-label">Jam Pulang</label>
                                    <input
                                        type="time"
                                        name="time_out"
                                        id="time_out"
                                        class="form-control  @error('time_out') is-invalid @enderror"
                                        wire:model="time_out"
                                    />
                                    @error('time_out')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="overdue" class="form-label">Terlambat</label>
                                    <select
                                        name="overdue"
                                        id="overdue"
                                        class="form-control  @error('overdue') is-invalid @enderror"
                                        wire:model="overdue"
                                    >
                                        <option value="0">TIDAK</option>
                                        <option value="1">YA, TERLAMBAT</option>
                                    </select>
                                    @error('overdue')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="overtime" class="form-label">Lembur</label>
                                    <select
                                        name="overtime"
                                        id="overtime"
                                        class="form-control  @error('overtime') is-invalid @enderror"
                                        wire:model="overtime"
                                    >
                                        <option value="0">TIDAK</option>
                                        <option value="1">YA, LEMBUR</option>
                                    </select>
                                    @error('overtime')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center">Silahkah pilih pegawai untuk melajutkan</div>
                    @endif

                </div>
                @if($selected_user)
                <div class="card-footer">
                    <button
                        wire:click="submitNewAttendance"
                        class="btn btn-primary float-end"
                    >Simpan</button>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

@section('custom-script')
    <script>
        window.addEventListener('showNotify', event => {
            showNotification(
                event.detail.type,
                event.detail.message,
                5000
            )
        })
    </script>
@endsection
