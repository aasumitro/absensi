<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="detailDepartmentMemberModal"
>
    <div
        class="modal-dialog modal-lg"
        role="document"
        tabindex="-1"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail akun & aktifitas terkini</h5>
            </div>
            <div class="modal-body">
                @if($current_user)
                    <h5>Detail</h5>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>Nama </td>
                            <td>{{$current_user->name}}</td>
                        </tr>
                        <tr>
                            <td>Nama pengguna </td>
                            <td>{{'@'.$current_user->username}}</td>
                        </tr>
                        <tr>
                            <td>Alamat email </td>
                            <td>{{$current_user->email}}</td>
                        </tr>
                        <tr>
                            <td>Nomor ponsel </td>
                            <td>(+62) {{$current_user->phone}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <h5>Aktifitas</h5>
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
                        @if($current_user_attendances->count() >= 0)
                            <tbody>
                            @foreach($current_user_attendances as $attendance)
                                <tr class="text-center">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$attendance->date}}</td>
                                    <td>
                                        @if($attendance->status === 'ATTEND')
                                            HADIR
                                        @else
                                            IZIN (<a href="{{route('private.file', ['id' => optional($attendance->attachment)->id])}}" target="_blank" class="text-info text-underline">lampiran</a>)
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
                        @endif
                    </table>
                    @if((int)$current_user_attendances->count() === 0)
                        <div class="text-center">Belum ada aktifitas</div>
                    @endif
                    @if((int)$current_user_attendances->count() >= 5)
                        <div class="text-center">
                            hanya 5 data yang akan ditampilkan, <br>untuk lebih lengkapnya lihat pada menu
                            <a href="#" class="text-info text-underline">laporan</a>
                        </div>
                    @endif
                @else
                    <div class="text-center">Loading . . .</div>
                @endif

            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-dark"
                    data-bs-dismiss="modal"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
