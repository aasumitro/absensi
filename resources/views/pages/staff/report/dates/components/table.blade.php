@if($format === "DETAIL")
<div class="card-body">
    @if($attendances)
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>SKPD</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Waktu (Datang/Pulang)</th>
                <th>Terlambat</th>
            </tr>
            </thead>
            <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$attendance->department->name}}</td>
                    <td>{{$attendance->user->name}}</td>
                    <td>
                        @if($attendance->status === 'ATTEND')
                            HADIR
                        @else
                            @if((int)$attendance->absent_type_id !== \App\Models\AbsentType::TANPA_KETERANGAN)
                                IZIN - {{strtoupper($attendance->absentType->description)}} ({{$attendance->absentType->name}}) <br>
                                lampiran: <a href="{{route('private.file', ['id' => optional($attendance->attachment)->id])}}" target="_blank" class="text-info text-underline">Klik untuk melihat</a>
                            @else
                                TIDAK HADIR
                            @endif
                        @endif
                    </td>
                    <td>{{$attendance->date}}</td>
                    <td>
                        @if($attendance->status === 'ATTEND')
                            {{\Carbon\Carbon::parse($attendance->datetime_in)->format('H:i')}}
                            /
                            {{$attendance->datetime_out
                                    ? \Carbon\Carbon::parse($attendance->datetime_out)->format('H:i')
                                    : "BELUM ABSEN"
                            }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($attendance->status === 'ATTEND')
                            {{$attendance->overdue ? 'YA' : 'TIDAK'}}
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

        <div class="mt-4 text-center">
            <nav class="d-inline-block text-center">
                <ul class="pagination mb-0">
                    {{ $attendances->appends(request()->query())->links('components.pagination') }}
                </ul>
            </nav>
        </div>
    @endif
</div>
@endif

@if($format === 'TOTAL')
    <div class="card-body">
        @if($attendances)
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>SKPD</th>
                    <th>Nama</th>
                    <th>Hadir</th>
                    <th>Terlambat</th>
                    {{--<th>Lembur</th>--}}
                    <th>Tidak Hadir</th>
                    <th>Sakit (SK)</th>
                    <th>Cuti (CT)</th>
                    <th>Tanpa Keterangan (TK)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($attendances as $attendance)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$attendance->department->name}}</td>
                        <td>{{$attendance->user->name}}</td>
                        <td>{{$attendance->user->attend_count}}</td>
                        <td>{{$attendance->user->attend_overdue_count}}</td>
                        {{--<td>{{$attendance->user->attend_overtime_count}}</td>--}}
                        <td>{{$attendance->user->absent_count}}</td>
                        <td>{{$attendance->user->absent_missing_count}}</td>
                        <td>{{$attendance->user->absent_sick_count}}</td>
                        <td>{{$attendance->user->absent_leave_count}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if($attendances->count() <= 0)
                <div class="mt-4 text-center">
                    Data tidak tersedia
                </div>
            @endif

            <div class="mt-4 text-center">
                <nav class="d-inline-block text-center">
                    <ul class="pagination mb-0">
                        {{ $attendances->appends(request()->query())->links('components.pagination') }}
                    </ul>
                </nav>
            </div>
        @endif
    </div>
@endif
