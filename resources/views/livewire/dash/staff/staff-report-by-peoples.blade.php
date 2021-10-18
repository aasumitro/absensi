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
                        autocomplete="off"
                    />
                </div>

                <div wire:loading class="text-center">
                    <div class="list-item">Searching...</div>
                </div>

                @if(!empty($query))
                    <div class="list-group border-3 mb-3">
                        @if($users->count() > 0)
                            @foreach($users as $i => $user)
                                <a
                                    href="#"
                                    wire:click.prevent="selectUser({{$user}})"
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
                    <div class="d-flex justify-content-between mb-3 mb-lg-0">
                        <div>
                            <h1 class="h4">Riwayat Presensi {{ $selected_user ? "dari $selected_user->name" : ''}}</h1>
                            <p>Daftar aktivitas presensi harian, anda dapat melakukan export data dengan menekan tombol export!</p>
                        </div>
                        <div>
                            @if($selected_user && $attendances)
                                @if($attendances->count() > 0)
                                    <button
                                        wire:click="performExportAttendance"
                                        class="btn btn-primary float-end"
                                    >Export Excel</button>
                                @endif
                            @endif
                        </div>
                    </div>

                    @if(!$selected_user)
                        <div class="text-center">Silahkah pilih pegawai untuk melajutkan</div>
                    @else
                        @if($attendances)
                            <table class="table">
                                <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Datang</th>
                                    <th>Pulang</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$attendance->date}}</td>
                                        <td>
                                            @if($attendance->status === 'ATTEND')
                                                HADIR
                                            @else
                                                IZIN - {{strtoupper($attendance->absentType->description)}} ({{$attendance->absentType->name}}) <br>
                                                <a href="{{route('private.file', ['id' => optional($attendance->attachment)->id])}}" target="_blank" class="text-info text-underline">file lampiran</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->status === 'ATTEND')
                                                {{\Carbon\Carbon::parse($attendance->datetime_in)->format('H:i:s')}}
                                                ({{$attendance->overdue ? 'TERLAMBAT' : 'TEPAT WAKTU'}})
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->status === 'ATTEND')
                                                {{
                                                    $attendance->datetime_out
                                                    ? \Carbon\Carbon::parse($attendance->datetime_out)->format('H:i:s')
                                                    : "BELUM ABSEN"
                                                }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            @if($attendances->count() <= 0)
                                <div class="mt-4 text-center">
                                    Data tidak tersedia
                                </div>
                            @endif
                        @else
                            <div class="mt-4 text-center">
                                Data tidak tersedia
                            </div>
                        @endif
                    @endif
                </div>
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
