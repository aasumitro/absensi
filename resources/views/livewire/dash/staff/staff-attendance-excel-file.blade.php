<div>
    <div class="row">
        <div class="col-12 col-md-4 mb-sm-3">
            <form wire:submit.prevent="previewFileUpload">
                <div class="card card-body shadow-sm">
                    <div class="mb-3 mb-lg-0">
                        <h1 class="h4">Form</h1>
                        <p>
                            <span class="text-warning">Perhatian:</span>
                            sebelum mengupload file excel presensi pastikan
                            data file excel sesuai dengan format yang disediakan
                            dan file excel harus bertipe (extensi) <code>.xls</code>
                            untuk format dapat diunduh pada link berikut:
                            <a
                                href="{{asset('assets/default/import_data_absensi.xls')}}"
                                class="text-info text-underline"
                            >
                                format import data presensi
                            </a>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Data presensi (excel file extension: <code>.xls</code>)</label>
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
                    <span>
                        Pastikan semua <code>kolom</code> pada file excel terisi dan tidak
                        ada data yang kosong agar proses <code>import data</code> berjalan
                        sesuai sebagaimana mestinya!
                    </span>
                    <button class="btn btn-primary mt-3" type="submit">
                        Pratinjau
                    </button>
                </div>
            </form>
        </div>

        <div class="col-12 col-md-8 mb-sm-3">
            <div class="card card-body shadow-sm table-responsive">
                <div class="d-flex justify-content-between mb-3 mb-lg-0">
                    <div>
                        <h1 class="h4">Pratinjau</h1>
                        <p>Tinjau kembali data sebelum melakukan aksi penyimpanan</p>
                    </div>
                    <div>
                        @if($temp && count($temp) <> count($data))
                            <button class="btn btn-success" wire:click="restoreDataFromTemp">
                                Restore
                            </button>
                        @endif
                        @if($data)
                            <button class="btn btn-primary" wire:click="processValidData">
                                Proses
                            </button>
                        @endif
                    </div>
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Pegawai</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($data)
                        @foreach($data as $key => $attendance)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    @php($username = (is_string($attendance['username']) ? explode('#', $attendance['username']) : ''))
                                    @if(!is_string($attendance['username']))
                                        {{$attendance['username']['name']}} ({{'@'.$attendance['username']['username']}})
                                    @else
                                        Tidak ada Pegawai dengan
                                        <br>username: <code>{{'@'.$username[1]}}</code>
                                        <br> <span class="text-danger">Data ini tidak akan diproses!</span>
                                    @endif
                                </td>
                                <td>{{$attendance['date']}}</td>
                                <td>
                                    DATANG: <code>{{$attendance['time_in']}}</code>
                                    <br>PULANG: <code>{{$attendance['time_out']}}</code>
                                </td>
                                <td>
                                    TERLAMBAT: <code>{{$attendance['overdue']}}</code>
                                    <br>LEMBUR: <code>{{$attendance['overtime']}}</code>
                                </td>
                                <td>
                                    <button
                                        wire:click="removeDataFromArray({{$key}})"
                                        class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    >
                                            <span class="icon icon-sm">
                                                <span class="fas fa-trash-alt icon-dark"></span>
                                            </span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                @if(!$data)
                    <div class="text-center py-3">
                        data tidak tersedia, silahkan upload file <code>.xls</code> (excel)
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@section('custom-script')
    <script>
        let loading = document.getElementById('loading')

        window.addEventListener('showNotify', event => {
            showNotification(
                event.detail.type,
                event.detail.message,
                5000
            )
        })

        window.addEventListener('onProcess', event => {
            if (event.detail.type === 'PROCESS') {
                loading.classList.remove('d-none')
            }

            if (event.detail.type === 'DONE') {
                loading.classList.add('d-none')
            }
        })
    </script>
@endsection
