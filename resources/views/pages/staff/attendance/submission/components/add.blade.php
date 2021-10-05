<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="addNewSubmission"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="performAddSubmission">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat pengajuan baru</h5>
                </div>
                <div class="modal-body">
                    <br>// search user
                    <br>// display user data (public)
                    <br>// show absent types select
                    <br>// show title input
                    <br>// show description input
                    <br>// show upload attachment input
                    <br>// show status select input
                    <br>// show notes when status === rejected input
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
                        Buat
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
