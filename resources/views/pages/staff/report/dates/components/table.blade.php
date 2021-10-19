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
                            IZIN - {{strtoupper($attendance->absentType->description)}} ({{$attendance->absentType->name}}) <br>
                            lampiran: <a href="{{route('private.file', ['id' => optional($attendance->attachment)->id])}}" target="_blank" class="text-info text-underline">Klik untuk melihat</a>
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
