<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="editUserAccountRequestModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performConfirmRequest">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terima permintaan pengajuan admin!</h5>
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
                        Terima
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
