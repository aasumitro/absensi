<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="addImportExcelDepartmentPeopleModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performAddNewUserFromFile">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import data pegawai</h5>
                </div>
                <div class="modal-body">
                    <p>
                        <span class="text-warning">Perhatian:</span>
                        sebelum mengupload file excel pegawai pastikan
                        data file excel sesuai dengan format yang disediakan
                        dan file excel harus bertipe (extensi) <code>.xls</code>
                        untuk format dapat diunduh pada link berikut:
                        <a
                            href="{{asset('assets/default/import_data_pegawai.xls')}}"
                            class="text-info text-underline"
                        >
                            format import data pegawai
                        </a>
                    </p>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Data pegawai (excel file)</label>
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
                        Pastikan semua <code>kolom</code> pada file excel terisi dan tidak ada data yang kosong agar proses <code>import data</code> berjalan sesuai sebagaimana mestinya!
                    </span>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-dark"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Proses
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
