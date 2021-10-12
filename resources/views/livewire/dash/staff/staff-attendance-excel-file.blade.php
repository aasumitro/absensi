<div>
    <div class="row">
        <div class="col-12 col-md-4 mb-sm-3">
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
                <button class="btn btn-primary mt-3">
                    Pratinjau
                </button>
            </div>
        </div>
        <div class="col-12 col-md-8 mb-sm-3">
            <div class="card card-body shadow-sm table-responsive">
                <div class="d-flex justify-content-between mb-3 mb-lg-0">
                    <div>
                        <h1 class="h4">Pratinjau</h1>
                        <p>Tinjau kembali data sebelum melakukan aksi penyimpanan</p>
                    </div>
                    <button class="btn btn-primary h-25">
                        Proses
                    </button>
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Pegawai</th>
                        <th>Tanggal</th>
                        <th>Waktu (Datang/Pulang)</th>
                        <th>Keterangan (Terlambat/Lembur)</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>A. A. Sumitro (@aasumitro)</td>
                            <td>21-10-2021</td>
                            <td>(IN/OUT) 08:27/16:22</td>
                            <td>HADIR - TIDAK/TIDAK</td>
                            <td>
                                <button
                                    onclick="showNotification('error', 'Aksi tidak diizinkan!')"
                                    class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                >
                                    <span class="icon icon-sm">
                                        <span class="fas fa-trash-alt icon-dark"></span>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
