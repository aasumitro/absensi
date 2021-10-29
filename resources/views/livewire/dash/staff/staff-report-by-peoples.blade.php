<div>
    @if($selected_user && $attendances)
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <i class="fas fa-fingerprint fa-2x"></i>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5"> TOTAL HADIR</h2>
                                <h3 class="mb-1">0</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-black-400 mb-0"> TOTAL HADIR</h2>
                                <h3 class="fw-extrabold mb-0">{{$user_attend_count}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5"> TOTAL TERLAMBAT</h2>
                                <h3 class="mb-1">0</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-black-400 mb-0"> TOTAL TERLAMBAT</h2>
                                <h3 class="fw-extrabold mb-0">{{$user_attend_overtime_count}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <i class="far fa-file-alt fa-2x"></i>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5"> TOTAL TIDAK HADIR</h2>
                                <h3 class="mb-1">0</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-black-400 mb-0"> TOTAL TIDAK HADIR</h2>
                                <h3 class="fw-extrabold mb-0">{{$user_absent_count}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <i class="fas fa-procedures fa-2x"></i>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5"> IZIN (SAKIT)</h2>
                                <h3 class="mb-1">0</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-black-400 mb-0"> IZIN (SAKIT)</h2>
                                <h3 class="fw-extrabold mb-0">{{$user_absent_sick_count}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <i class="fas fa-road fa-2x"></i>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5"> IZIN (CUTI)</h2>
                                <h3 class="mb-1">0</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-black-400 mb-0"> IZIN (CUTI)</h2>
                                <h3 class="fw-extrabold mb-0">{{$user_absent_leave_count}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <i class="fas fa-running fa-2x"></i>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5"> Tanpa Keterangan</h2>
                                <h3 class="mb-1">0</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-black-400 mb-0">  TANPA KETERANGAN</h2>
                                <h3 class="fw-extrabold mb-0">{{$user_absent_missing_count}}</h3>
                                <h4 class="font-small mb-2 text-white">-</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
                    </div>

                    @if(!$selected_user)
                        <div class="text-center">Silahkah pilih pegawai untuk melajutkan</div>
                    @else
                        @if(count($attendances) > 0)
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <div class="form-group">
                                    <label for="for_date">Rentang tanggal</label>
                                    <div id="for_date" class="d-flex">
                                        <label for="date_from"></label>
                                        <input
                                            wire:model="from_date"
                                            type="date"
                                            class="form-control datepicker"
                                            name="from_date"
                                            id="date_from"
                                            value="{{ (app('request')->input('from_date')) ?? ''}}"
                                            style="border-radius: 30px 0 0 30px !important; height: 33px !important; font-size:13px; padding: 0 10px !important; -webkit-appearance: none;"
                                        >
                                        <label for="date_to"></label>
                                        <input
                                            wire:model="to_date"
                                            type="date"
                                            class="form-control datepicker"
                                            name="to_date"
                                            id="date_to"
                                            value="{{ (app('request')->input('to_date')) ?? ''}}"
                                            style="border-radius: 0 30px 30px 0 !important; height: 33px !important; font-size:13px; padding: 0 10px !important; -webkit-appearance: none;"
                                        >
                                    </div>
                                </div>
                                <button
                                    wire:click.prevent="performExportAttendance"
                                    class="btn btn-primary mt-3 float-end"
                                >Export Excel</button>
                            </div>
                           <div class="table-responsive">
                               <table class="table table-hover">
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
                                                   @if((int)$attendance->absent_type_id !== \App\Models\AbsentType::TANPA_KETERANGAN)
                                                       IZIN - {{strtoupper($attendance->absentType->description)}} ({{$attendance->absentType->name}}) <br>
                                                       <a href="{{route('private.file', ['id' => optional($attendance->attachment)->id])}}" target="_blank" class="text-info text-underline">file lampiran</a>
                                                   @else
                                                       TIDAK HADIR
                                                   @endif
                                               @endif
                                           </td>
                                           <td>
                                               @if($attendance->status === 'ATTEND')
                                                   {{\Carbon\Carbon::parse($attendance->datetime_in)->format('H:i:s')}}
                                                   ({{$attendance->overdue ? 'TERLAMBAT' : 'TEPAT WAKTU'}})

                                                   @if($attendance->type === 'PICTURE' && $attendance->attachment_id)
                                                       <br>
                                                       Absen dengan Foto:: <a href="{{route('private.file', ['id' => optional($attendance->attachment)->id])}}" target="_blank" class="text-info text-underline">lampiran</a>
                                                   @endif
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

                                                   @if($attendance->type === 'PICTURE' && $attendance->attachment_out_id)
                                                       <br>
                                                       Absen dengan Foto: <a href="{{route('private.file', ['id' => optional($attendance->attachmentOut)->id])}}" target="_blank" class="text-info text-underline">lampiran</a>
                                                   @endif
                                               @else
                                                   -
                                               @endif
                                           </td>
                                       </tr>
                                   @endforeach
                                   </tbody>
                               </table>
                           </div>

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
