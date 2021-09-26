<div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="deleteModal"
    aria-labelledby="deleteModal"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-sm"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
            </div>
            <div class="modal-body">
                <p>
                    Apakah anda yakin untuk menghapus data ini?
                    <br> data tidak dapat di pulihkan kembali.
                </p>
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
                    type="button"
                    wire:click="performDestroy({{$selected_id}})"
                    class="btn btn-danger"
                    data-bs-dismiss="modal"
                >
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
