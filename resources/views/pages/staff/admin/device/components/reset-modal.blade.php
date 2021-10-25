<div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="resetModal"
    aria-labelledby="resetModal"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-md"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
            </div>
            <div class="modal-body">
                <p>
                    Aksi ini memungkinkan  <code>data kredensial</code> digunakan pada perangkat baru,
                    apa anda yakin ingin melakukan aksi ini?
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
                    wire:click="performResetDevice"
                    class="btn btn-danger"
                    data-bs-dismiss="modal"
                >
                    Reset
                </button>
            </div>
        </div>
    </div>
</div>
