<table>
    <thead>
    {{-- [START] HEADER --}}
    <tr style="text-align: center;">
        <th colspan="9" rowspan="3" style="border: 2px solid black;">Laporan Pegawai format Detail</th>
    </tr>
    <tr><th colspan="9"></th></tr>
    <tr><th colspan="9"></th></tr>
    <tr>
        <th colspan="9" rowspan="4" style="border: 2px solid black;">
            SKPD: {{$reports['department']->name}} <br>
            ZONA WAKTU: [{{$reports['department']->timezone->title}}] {{$reports['department']->timezone->locale}} <br>
            RENTANG WAKTU:
            {{\Illuminate\Support\Carbon::parse($reports['from_date'])->format('d-m-Y')}}
            sampai
            {{\Illuminate\Support\Carbon::parse($reports['to_date'])->format('d-m-Y')}} <br>
            TOTAL PEGAWAI: {{$reports['department']->members_count}}
        </th>
    </tr>
    <tr><th colspan="9"></th></tr>
    <tr><th colspan="9"></th></tr>
    <tr><th colspan="9"></th></tr>
    <tr><th colspan="9"></th></tr>
    {{-- [END] HEADER --}}

    <tr>
        <th style="border: 2px solid black;">Nomor</th>
        <th style="border: 2px solid black;">Nama</th>
        <th style="border: 2px solid black;">Hari</th>
        <th style="border: 2px solid black;">Tanggal</th>
        <th style="border: 2px solid black;">Status</th>
        <th style="border: 2px solid black;">Masuk</th>
        <th style="border: 2px solid black;">Keluar</th>
        <th style="border: 2px solid black;">Terlambat</th>
        <th style="border: 2px solid black;">Lembur</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reports['attendances'] as $data)
        <tr >
            <td style="border: 2px solid black;">{{ $loop->iteration }}</td>
            <td style="border: 2px solid black;">{{ $data['user']['name'] }}</td>
            <td style="border: 2px solid black;">{{ to_indonesia_day(\Carbon\Carbon::parse($data['date'])->format('l')) }}</td>
            <td style="border: 2px solid black;">{{ $data['date'] }}</td>
            <td style="border: 2px solid black;">
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
            <td style="border: 2px solid black;">
                @if($data['status'] === 'ABSENT')
                    -
                @else
                    {{ \Carbon\Carbon::createFromDate($data['datetime_in'])->format('H:i') }}
                @endif
            </td>
            <td style="border: 2px solid black;">
                @if($data['status'] === 'ABSENT')
                    -
                @else
                    {{ \Carbon\Carbon::createFromDate($data['datetime_out'])->format('H:i') }}
                @endif
            </td>
            <td style="border: 2px solid black;">
                @if($data['status'] === 'ABSENT')
                    -
                @else
                    {{ (($data['overdue'] === 1) ? 'YA' : 'TIDAK') }}
                @endif
            </td>
            <td style="border: 2px solid black;">
                @if($data['status'] === 'ABSENT')
                    -
                @else
                    {{ (($data['overtime'] === 1) ? 'YA' : 'TIDAK') }}
                @endif
            </td>
        </tr>
    @endforeach
</table>
