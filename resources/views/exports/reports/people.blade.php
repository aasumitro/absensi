{{--<h2 style="text-align: center">--}}
{{--    <strong>--}}
{{--        Laporan Pegawai--}}
{{--    </strong>--}}
{{--</h2>--}}

{{--<hr>--}}

{{--<h4 style="text-align: center">--}}
{{--    <strong>--}}
{{--        Nama : {{$reports['name']}}--}}
{{--    </strong>--}}
{{--</h4>--}}
{{--<h4 style="text-align: center">--}}
{{--    <strong>--}}
{{--        SKPD : {{$reports['department']}}--}}
{{--    </strong>--}}
{{--</h4>--}}
{{--<h4 style="text-align: center">--}}
{{--    <strong>--}}
{{--        RENTANG : TANGAL DARI SAMPAI--}}
{{--    </strong>--}}
{{--</h4>--}}

{{--<hr>--}}

{{--<h4 style="text-align: center">--}}
{{--    <strong>--}}
{{--        TOTAL HADIR : {{$reports['attend_total']}} - {{$reports['attend_overtime_total']}} TERLAMBAT--}}
{{--    </strong>--}}
{{--</h4>--}}
{{--<h4 style="text-align: center">--}}
{{--    <strong>--}}
{{--        TOTAL TIDAK HADIR : {{$reports['absent_total']}}--}}
{{--    </strong>--}}
{{--</h4>--}}
{{--<h4 style="text-align: center">--}}
{{--    <strong>--}}
{{--        TOTAL TIDAK HADIR (SAKIT) : {{$reports['absent_sick_total']}}--}}
{{--    </strong>--}}
{{--</h4>--}}
{{--<h4 style="text-align: center">--}}
{{--    <strong>--}}
{{--        TOTAL TIDAK HADIR (IZIN) : {{$reports['absent_leave_total']}}--}}
{{--    </strong>--}}
{{--</h4>--}}
{{--<h4 style="text-align: center">--}}
{{--    <strong>--}}
{{--        TOTAL TIDAK HADIR (TANPA KETERANGAN) : {{$reports['absent_missing_total']}}--}}
{{--    </strong>--}}
{{--</h4>--}}

{{--<hr>--}}

<table style="border: 1px solid black;">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Hari</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Terlambat</th>
            <th>Lembur</th>
        </tr>
    </thead>
    <tbody>
    @foreach($reports['attendances'] as $data)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ to_indonesia_day(\Carbon\Carbon::parse($data['date'])->format('l')) }}</td>
            <td>{{ $data['date'] }}</td>
            <td>
                @if($data['status'] === 'ABSENT')
                    @if((int)$data['absent_type_id'] !== \App\Models\AbsentType::TANPA_KETERANGAN)
                        IZIN {{strtoupper($data['absent_type']['description'])}}
                    @else
                        TIDAK HADIR
                    @endif
                @else
                    HADIR
                @endif
            </td>
            <td>
                @if($data['status'] === 'ABSENT')
                    -
                @else
                    {{ \Carbon\Carbon::createFromDate($data['datetime_in'])->format('h:i') }}
                @endif
            </td>
            <td>
                @if($data['status'] === 'ABSENT')
                    -
                @else
                    {{ \Carbon\Carbon::createFromDate($data['datetime_out'])->format('h:i') }}
                @endif
            </td>
            <td>
                @if($data['status'] === 'ABSENT')
                    -
                @else
                    {{ (($data['overdue'] === 1) ? 'YA' : 'TIDAK') }}
                @endif
            </td>
            <td>
                @if($data['status'] === 'ABSENT')
                    -
                @else
                    {{ (($data['overtime'] === 1) ? 'YA' : 'TIDAK') }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
