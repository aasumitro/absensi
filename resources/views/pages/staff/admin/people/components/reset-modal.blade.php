<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="editUserAccountResetDeviceModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performResetDevice">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Anda yakin ingin mereset akses perangakat?</h5>
                </div>
                <div class="modal-body">
                    <p>Dengan melakukan aksi ini anda mengizinkan pengguna dengan akun ini untuk mengakses akun dari perangakt lain</p>
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
                        Reset
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
