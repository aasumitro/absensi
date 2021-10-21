<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="detailDepartmentDeviceModal"
>
    <div
        class="modal-dialog modal-lg"
        role="document"
        tabindex="-1"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail perangkat & aktifitas terkini</h5>
            </div>
            <div class="modal-body">
                @if($device_detail)
                    <h5>Detail</h5>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Nama pemilik </td>
                                    <td>{{$device_detail->department->name}}</td>
                                </tr>
                                <tr>
                                    <td>Zona waktu </td>
                                    <td>
                                        [{{$device_detail->department->timezone->title}}]
                                        {{$device_detail->department->timezone->locale}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>UUID </td>
                                    <td>{{$device_detail->unique_id}}</td>
                                </tr>
                                <tr>
                                    <td>Nama perangkat </td>
                                    <td>{{$device_detail->name}}</td>
                                </tr>
                                <tr>
                                    <td>Waktu refresh dan mode </td>
                                    <td>
                                        {{$device_detail->refresh_time}}
                                        {{$device_detail->refresh_time_mode === 'MINUTES' ? 'Menit' : 'Detik'}}
                                    </td>
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
                                <th>Nama Pegawai</th>
                                <th>Datang</th>
                                <th>Pulang</th>
                            </tr>
                        </thead>
                        @if($device_detail->attendances_count >= 1)
                        <tbody>
                            @foreach($device_detail->attendances as $attendance)
                                <tr class="text-center">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$attendance->date}}</td>
                                    <td>
                                        @if($attendance->status === 'ATTEND')
                                            HADIR
                                        @else
                                            @if((int)$attendance->absent_type_id !== \App\Models\AbsentType::TANPA_KETERANGAN)
                                                IZIN (<a href="{{route('private.file', ['id' => optional($attendance->attachment)->id])}}" target="_blank" class="text-info text-underline">lampiran</a>)
                                            @else
                                                TIDAK HADIR
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{$attendance->user->name}}</td>
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

                    @if((int)$device_detail->attendances_count === 0)
                        <div class="text-center">Belum ada aktifitas</div>
                    @endif

                    @if((int)$device_detail->attendances_count >= 5)
                    {{-- TODO update link url --}}
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
