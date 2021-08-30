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
                <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body">
                <p>
                    Are you sure to destroy this record?
                    <br> this process cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-dark"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    wire:click="performDestroy({{$selected_id}})"
                    class="btn btn-danger"
                >
                    Destroy
                </button>
            </div>
        </div>
    </div>
</div>
